<?php namespace App\Repositories\SalesForce;

use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesForceRepository
{
    /**
     * @param $objectName
     * @param array $params
     * @param bool $sForceAutoAssign
     */
    public function create($objectName, array $params, $sForceAutoAssign = false)
    {
        return Forrest::sobjects($objectName, [
            'method' => 'post',
            'body' => [ $params ],
            'headers' => [
                'Sforce-Auto-Assign' => $sForceAutoAssign
            ]
        ]);
    }

    /**
     * @param $objectName
     * @param $id
     * @return mixed
     */
    public function find($objectName, $id)
    {
        $result = Forrest::query("SELECT FirstName, LastName FROM $objectName WHERE Id='$id'");

        if(!count($result["records"])) {
            return null;
        }

        return $result["records"][0];
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