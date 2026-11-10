<?php

namespace App\Services\Spip;

use App\Models\City;
use App\Models\OfferGenre;
use App\Models\Spip\Article;
use App\Models\Spip\Auteur;
use App\Repositories\Users\UserRepository;
use App\Services\Documents\DocumentService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\File;

class SpipService
{
    /**
     * @var DatabaseManager
     */
    protected $db;

    /**
     * @var UserRepository
     */
    private $localUserRepository;

    /**
     * @var DocumentService
     */
    protected $documentService;

    public function __construct(UserRepository $userRepository, DocumentService $documentService)
    {
        $this->localUserRepository = $userRepository;
        $this->documentService = $documentService;
    }

    public function userExists(string $email)
    {
        return $this->db
            ->table('spip_auteurs')
            ->where('email', $email)
            ->exists();
    }

    public function getUserFromCredentials(string $email, string $password)
    {
        return $this->db
            ->table('spip_auteurs')
            ->where('email', $email)
            ->where('bio', $password)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Auteur[]
     */
    public function getAllUsersWithAds()
    {

        DB::enableQueryLog();

        $auteurs = Auteur::with(['articles', 'articles.mots', 'articles.url'])
            ->whereExists(function (Builder $query) {
                $query->select(DB::raw(1))
                    ->from('spip_auteurs_liens')
                    ->whereRaw('spip_auteurs.id_auteur = spip_auteurs_liens.id_auteur')
                    ->where('objet', 'article');
            })
            ->where('email', '<>', '')
            ->get();

        return $auteurs;
    }

    public function getAllAdsWithUsers()
    {
        $articles = Article::with(['auteurs'])->get();

        return $articles;
    }

    public function getLocalAdTypeMapping(Collection $mots)
    {
        $motIds = $mots->pluck('id_mot', 'id_mot');

        $adTypeMapping = [
            4 => 'land_offer',
            5 => 'land_seek',
            207 => 'job_offer',
            210 => 'job_seek',
        ];

        foreach ($motIds as $motId) {
            if (isset($adTypeMapping[$motId])) {
                return $adTypeMapping[$motId];
            }
        }
    }

    public function getLocalRegionMapping(Collection $mots)
    {
        $motIds = $mots->pluck('id_mot', 'id_mot');

        // dd($motIds);

        $regionMapping = [
            162 => 11,
            156 => 14,
            141 => 16,
            154 => 8,
            155 => 13,
            151 => 7,
            145 => 11,
            153 => 18,
            161 => 10,
            163 => 6,
            147 => 15,
            152 => 14,
            160 => 11,
            146 => 15,
            149 => 9,
            159 => 12,
            150 => 14,
            142 => 17,
            139 => 16,
        ];

        foreach ($motIds as $motId) {
            if (isset($regionMapping[$motId])) {
                return $regionMapping[$motId];
            }
        }
    }

    public function getLocalOfferGenresMapping(Collection $mots)
    {
        $motIds = $mots->pluck('id_mot', 'id_mot');

        $offerGenres = [];

        $offerGenresMapping = [
            6 => 2,
            7 => 1,
        ];

        foreach ($motIds as $motId) {
            if (isset($offerGenresMapping[$motId])) {
                $offerGenres[] = $offerGenresMapping[$motId];
            }
        }

        return $offerGenres;
    }

    public function getLocalDocumentsMapping(Collection $spipDocuments, $userId)
    {
        $documentIds = [];

        foreach ($spipDocuments as $document) {
            $filePath = str_replace('/', DIRECTORY_SEPARATOR, storage_path('app/spip/'.$document->fichier));
            if (! is_file($filePath)) {
                continue;
            }
            $file = new File($filePath);
            $document = $this->documentService->create($file, 'ads/'.$userId, $userId);
            $documentIds[] = $document->id;
        }

        return $documentIds;
    }

    public function hasAdType(Article $article)
    {
        return ! empty($this->getLocalAdTypeMapping($article->mots));
    }

    public function getLocalAdMapping(Article $article, $userId)
    {
        $offerGenres = $this->getLocalOfferGenresMapping($article->mots);
        $isBuyOffer = in_array(OfferGenre::ID_VENTE, $offerGenres);
        $formattedPrice = preg_replace('/[ .]/', '', $article->prix);

        return [
            'title' => $article->titre,
            'about_content' => $article->surtitre,
            'about_project_content' => $article->texte,
            'created_at' => $article->date,
            'updated_at' => $article->maj,
            'is_draft' => $article->statut !== 'publie' ? 1 : 0,
            'ad_type' => $this->getLocalAdTypeMapping($article->mots),
            'locationable' => [
                'regions' => [$this->getLocalRegionMapping($article->mots)],
            ],
            'land_seek' => [
                'offer_genres' => $offerGenres,
                'price_max' => $isBuyOffer ? $formattedPrice : '',
            ],
            'land_offer' => [
                'offer_genres' => $offerGenres,
                'price' => $isBuyOffer ? $formattedPrice : '',
                'rent_price' => $isBuyOffer ? '' : $formattedPrice,
            ],
            'job_offer' => [

            ],
            'job_seek' => [

            ],
            'documents_ids' => $this->getLocalDocumentsMapping($article->documents, $userId),
            // Taken from the first ad found
            'accept_share_contact_infos' => $article->soustitre === 'oui' ? 1 : 0,
            'origin' => 'spip',
        ];
    }

    /**
     * @throws \Throwable
     */
    public function getLocalUserMapping(Auteur $auteur)
    {
        return [
            'first_name' => $auteur->cpnom,
            'name' => $auteur->cnom,
            'phone' => $auteur->ctel,
            'street' => implode(', ', array_filter(array_unique([$auteur->cadresse, $auteur->cadresse2, $auteur->cadresse3]))),
            'zip_code_id' => $this->findMatchingCityId($auteur),

            'email' => $auteur->email,
            // bio contains the unencrypted password ( yes -_- )
            'password' => $auteur->bio,

            'origin' => 'spip',
        ];
    }

    /**
     * Find the city matching a provided zip code and the lowest word distance to
     * available cities
     *
     * @return City
     */
    public function findMatchingCityId(Auteur $auteur)
    {
        $city = City::where('zip_code', $auteur->cp)
            ->get()
            ->sort(function (City $city) use ($auteur) {
                return levenshtein(strtolower($auteur->ville), strtolower($city->name));
            })
            ->first();

        if (! $city) {
            $city = City::where('name', 'LIKE', trim(preg_replace('/cedex/i', '', $auteur->ville)))
                ->get()
                ->sort(function (City $city) use ($auteur) {
                    return levenshtein(strtolower($auteur->ville), strtolower($city->name));
                })
                ->first();

            // dd($auteur->cp, $auteur->ville, $cities);
        }

        if (! $city) {
            // dd($auteur->cp, $auteur->ville);
            return null;
        }

        return $city->id;
    }
}
