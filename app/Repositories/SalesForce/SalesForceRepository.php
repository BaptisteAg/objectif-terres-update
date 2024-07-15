<?php namespace App\Repositories\SalesForce;

use Omniphx\Forrest\Authentications\UserPasswordSoap;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;
use Omniphx\Forrest\Repositories\TokenRepository;

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
     * @param string[] $select
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
            if(is_array($value)) {
                $value = $key . " IN ('" . implode("','", $value) . "')";
            }
            else {
                $value = $key . " = '" . $value . "'";
            }
        });
        $query .= implode(' AND ', $where);

        $result = $this->authenticated(fn() => $this->forrest->query($query));

        return $result["records"];
    }

    public function findAll(string $objectName, array $select = ["Id"])
    {
        $query = "SELECT ".implode(',', $select)." FROM $objectName";

        $result = $this->authenticated(fn() => $this->forrest->query($query));

        return $result["records"];
    }

    /**
     * @param $objectName
     * @param array $params
     * @param bool $sForceAutoAssign
     */
    public function create($objectName, array $params, $sForceAutoAssign = false)
    {
        return $this->authenticated(fn() => $this->forrest->sobjects($objectName, [
            'method' => 'post',
            'body' => $params,
            /*'headers' => [
                'Sforce-Auto-Assign' => $sForceAutoAssign
            ]*/
        ]));
    }

    /**
     * @param $objectName
     * @param $sfId
     * @param array $params
     */
    public function update($objectName, $id, array $params)
    {
        return $this->authenticated(fn() => $this->forrest->sobjects($objectName. '/' . $id,[
            'method' => 'patch',
            'body'   => $params
        ]));
    }

    public function batchCreate($objectName, $rows)
    {
        return $this->authenticated(fn() => $this->forrest->composite('batch', [
            'allOrNone' => true,
            'records' => array_map(fn($row) => [
                'method' => 'POST',
                'url' => '/services/data/v52.0/sobjects/'.$objectName.'/',
                'referenceId' => $row['referenceId'],
                'body' => $row['body']
            ], $rows)
        ]));
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
		/** @var TokenRepository $forrestToken */
        $forrestToken = app('forrest_token');

		if(!$forrestToken->has()) {
			$this->forrest->authenticate();
		}
    }

    private function authenticated(\Closure $closure)
    {
        $this->authenticate();

        return $closure();
    }
}
