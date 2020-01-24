<?php


namespace App\Http\Services\SalesForces;


use Illuminate\Support\Facades\Redirect;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesForceService
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAuthenticate()
    {
        Forrest::authenticate();
        return Redirect::to('/');
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAuthenticateUser($username, $password)
    {
        Forrest::authenticateUser(getenv('LOGIN_URL'), $username, $password);
        return Redirect::to('/');
    }

    /**
     * @param $object
     * @param array $params
     * @param bool $sForceAutoAssign
     */
    public function createNewObject($object, array $params, $sForceAutoAssign = false)
    {
        Forrest::sobjects($object, [
            'method' => 'post',
            'body' => [ $params ],
            'headers' => [
                'Sforce-Auto-Assign' => $sForceAutoAssign
            ]
        ]);
    }


    /**
     * @param $object
     * @param $sf_id
     * @param array $params
     */
    private function updateObject($object, $sf_id, array $params)
    {
        Forrest::sobjects($object. '/' . $sf_id,[
            'method' => 'put',
            'body'   => [ $params ]
//                'Name'  => 'Dunder Mifflin',
//                'Phone' => '555-555-5555'
        ]);
    }

    /**
     * @param $object
     * @param $sf_id
     */
    public function deleteContact($object, $sf_id)
    {
        Forrest::sobjects($object. '/' . $sf_id, [
            'method' => 'delete'
        ]);
    }
}
