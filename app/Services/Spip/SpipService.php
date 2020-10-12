<?php namespace App\Services\Spip;

use App\Models\City;
use App\Models\Spip\Article;
use App\Models\Spip\Auteur;
use App\Models\Spip\Document;
use App\Models\Spip\Mot;
use App\Repositories\Users\UserRepository;
use App\Services\Documents\DocumentService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $auteurs = Auteur::with(['articles', 'articles.mots'])
            ->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                ->from('spip_auteurs_liens')
                ->whereRaw('spip_auteurs.id_auteur = spip_auteurs_liens.id_auteur')
                ->where('objet', 'article');
            })
            ->where('email', '<>', '')
            ->where('bio', '<>', '')
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
        $motIds = $mots->pluck("id_mot", "id_mot");

        $adTypeMapping = [
            4 => "land_offer",
            5 => "land_offer",
        ];

        foreach($motIds as $motId) {
            if(isset($adTypeMapping[$motId])) {
                return $adTypeMapping[$motId];
            }
        }
    }

    public function getLocalRegionMapping(Collection $mots)
    {
        $motIds = $mots->pluck("id_mot", "id_mot");

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

        foreach($motIds as $motId) {
            if (isset($regionMapping[$motId])) {
                return $regionMapping[$motId];
            }
        }
    }

    public function getLocalOfferGenresMapping(Collection $mots)
    {
        $motIds = $mots->pluck("id_mot", "id_mot");

        $offerGenres = [];

        $offerGenresMapping = [
            6 => 2,
            7 => 1
        ];

        foreach($motIds as $motId) {
            if (isset($offerGenresMapping[$motId])) {
                $offerGenres[] = $offerGenresMapping[$motId];
            }
        }

        return $offerGenres;
    }

    public function getLocalDocumentsMapping(Collection $spipDocuments, $userId)
    {
        $documentIds = [];

        foreach($spipDocuments as $document) {
            $filePath = str_replace("/", DIRECTORY_SEPARATOR, storage_path('app/spip/'.$document->fichier));
            if(!is_file($filePath)) {
                continue;
            }
            $file = new File($filePath);
            $document = $this->documentService->create($file, 'ads/'.$userId, $userId);
            $documentIds[] = $document->id;
        }

        return $documentIds;
    }

    public function getLocalAdMapping(Article $article, $userId)
    {
        $offerGenres = $this->getLocalOfferGenresMapping($article->mots);
        $isBuyOffer = in_array(7, $offerGenres);

        return [
            'title' => utf8_encode($article->titre),
            'about_content' => utf8_encode($article->surtitre),
            'about_project_content' => utf8_encode($article->texte),
            'created_at' =>  $article->date,
            'is_draft' => $article->statut !== "publie" ? 1 : 0,
            'ad_type' => $this->getLocalAdTypeMapping($article->mots),
            'locationable' => [
                'regions' => [$this->getLocalRegionMapping($article->mots)]
            ],
            'land_seek' => [
                'offer_genres' => $this->getLocalOfferGenresMapping($article->mots),
                'price_max' => $isBuyOffer ? $article->prix : '',
            ],
            'land_offer' => [
                'offer_genres' => $offerGenres,
                'price' => $isBuyOffer ? $article->prix : '',
                'rent_price' => $isBuyOffer ? '' : $article->prix,
            ],
            'job_offer' => [

            ],
            'job_seek' => [

            ],
            'document_ids' => $this->getLocalDocumentsMapping($article->documents, $userId)
        ];
    }


    /**
     * @param Auteur $auteur
     * @throws \Throwable
     */
    public function getLocalUserMapping(Auteur $auteur)
    {
        return [
            'first_name' => utf8_encode($auteur->cpnom),
            'name' => utf8_encode($auteur->cnom),
            'phone' => utf8_encode($auteur->ctel),
            'street' => utf8_encode(implode(', ', array_filter(array_unique([$auteur->cadresse, $auteur->cadresse2, $auteur->cadresse3])))),
            'zip_code_id' => $this->findMatchingCityId($auteur),

            'email' => utf8_encode($auteur->email),
            // bio contains the unencrypted password ( yes -_- )
            'password' => Hash::make(utf8_encode($auteur->bio)),

            // Taken from the first ad found
            'accept_share_contact_infos' => $auteur->articles->first->soustitre === 'oui' ? 1 : 0,

            'origin' => 'spip'
        ];
    }

    /**
     * Find the city matching a provided zip code and the lowest word distance to
     * available cities
     *
     * @param Auteur $auteur
     * @return City
     */
    public function findMatchingCityId(Auteur $auteur)
    {
        $city =  City::where("zip_code", $auteur->cp)
            ->get()
            ->sort(function (City $city) use ($auteur) {
                return levenshtein(strtolower($auteur->ville), strtolower($city->name));
            })
            ->first();

        if(!$city) {
            $city =  City::where("name", 'LIKE',  trim(preg_replace('/cedex/i', '', $auteur->ville)))
                ->get()
                ->sort(function (City $city) use ($auteur) {
                    return levenshtein(strtolower($auteur->ville), strtolower($city->name));
                })
                ->first();

            //dd($auteur->cp, $auteur->ville, $cities);
        }

        if(!$city) {
            //dd($auteur->cp, $auteur->ville);
            return null;
        }

        return $city->id;
    }

}
