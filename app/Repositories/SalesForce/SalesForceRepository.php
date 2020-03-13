<?php namespace App\Repositories\SalesForce;

use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesForceRepository
{
    /**
     * @param $objectName
     * @param $id
     * @return mixed
     */
    public function find($objectName, $id)
    {
        $entities = $this->findWhere($objectName, ["Id" => $id]);

        if(!count($entities)) {
            return null;
        }

        return $entities[0];
    }

    public function findWhere(string $objectName, array $fields)
    {
        $query = "SELECT FirstName, LastName FROM $objectName WHERE ";
        array_walk($fields, function (&$value, $key) {
            $value = "$key='".addslashes($value)."'";
        });
        $query .= implode(' AND ', $fields);

        $result = Forrest::query($query);

        return $result["records"];
    }

    /**
     * @param $objectName
     * @param array $params
     * @param bool $sForceAutoAssign
     */
    public function create($objectName, array $params, $sForceAutoAssign = false)
    {
        return Forrest::sobjects($objectName, [
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
    private function update($objectName, $id, array $params)
    {
        return Forrest::sobjects($objectName. '/' . $id,[
            'method' => 'put',
            'body'   => [ $params ]
        ]);
    }

    /**
     * @param $objectName
     * @param $sfId
     */
    public function delete($objectName, $id)
    {
        return Forrest::sobjects($objectName. '/' . $id, [
            'method' => 'delete'
        ]);
    }

    /**
     * @param $userId
     * @param $newPassword
     */
    public function updateUserPassword($userId, $newPassword)
    {
        Forrest::sobjects('User/' . $userId . '/password', [
            'method' => 'post',
            'body' => [
                "NewPassword" => $newPassword
            ]
        ]);
    }
}
