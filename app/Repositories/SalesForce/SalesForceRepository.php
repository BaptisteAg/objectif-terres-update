<?php namespace App\Repositories\SalesForce;

use Omniphx\Forrest\Authentications\UserPasswordSoap;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesForceRepository
{
    /**
     * @var UserPasswordSoap
     */
    protected $forrest;

    public function __construct()
    {
        $this->forrest = app('forrest');
    }

    /**
     * @param $objectName
     * @param $id
     * @return mixed
     */
    public function find($objectName, $id, $select = ["Id"])
    {
        $entities = $this->findWhere($objectName, ["Id" => $id], $select);

        if(!count($entities)) {
            return null;
        }

        return $entities[0];
    }

    /**
     * @param string $objectName
     * @param array $where
     * @param array $select
     * @return mixed
     */
    public function findWhere(string $objectName, array $where, array $select = ["Id"])
    {
        $query = "SELECT ".implode(',', $select)." FROM $objectName WHERE ";
        array_walk($where, function (&$value, $key) {
            $value = "$key='".addslashes($value)."'";
        });
        $query .= implode(' AND ', $where);


        $result = $this->forrest->query($query);

        return $result["records"];
    }

    /**
     * @param $objectName
     * @param array $params
     * @param bool $sForceAutoAssign
     */
    public function create($objectName, array $params, $sForceAutoAssign = false)
    {
        return $this->forrest->sobjects($objectName, [
            'method' => 'post',
            'body' => $params,
            /*'headers' => [
                'Sforce-Auto-Assign' => $sForceAutoAssign
            ]*/
        ]);
    }

    /**
     * @param $objectName
     * @param $sfId
     * @param array $params
     */
    public function update($objectName, $id, array $params)
    {
        return $this->forrest->sobjects($objectName. '/' . $id,[
            'method' => 'post',
            'body'   => $params
        ]);
    }

    /**
     * @param $userId
     * @param $newPassword
     */
    public function updateUserPassword($userId, $newPassword)
    {
        $this->update('User', $userId . '/password', [
            "NewPassword" => $newPassword
        ]);
    }

    /**
     * @param $objectName
     * @param $sfId
     */
    public function delete($objectName, $id)
    {
        return $this->forrest->sobjects($objectName. '/' . $id, [
            'method' => 'delete'
        ]);
    }

    public function authenticate()
    {
        $this->forrest->authenticate();
    }
}
