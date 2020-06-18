<?php namespace App\Services\Spip;

use Illuminate\Database\DatabaseManager;

class SpipService
{
    /**
     * @var DatabaseManager
     */
    protected $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db->connection('mysql_spip');
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
}
