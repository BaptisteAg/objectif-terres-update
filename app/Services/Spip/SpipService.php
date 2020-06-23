<?php namespace App\Services\Spip;

use App\Models\City;
use App\Models\Spip\Article;
use App\Models\Spip\Auteur;
use App\Repositories\Users\UserRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function __construct(DatabaseManager $db, UserRepository $userRepository)
    {
        $this->db = $db->connection('mysql_spip');
        $this->localUserRepository = $userRepository;
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
        $auteurs = Auteur::with(['articles'])
            ->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                ->from('spip_auteurs_liens')
                ->whereRaw('spip_auteurs.id_auteur = spip_auteurs_liens.id_auteur')
                ->where('objet', 'article');
            })
            ->where('email', '<>', '')
            ->where('bio', '<>', '')
            ->where('statut', '=', '6forum')
            ->get();

        return $auteurs;
    }

    public function getAllAdsWithUsers()
    {
        $articles = Article::with(['auteurs'])->get();

        return $articles;
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
