<?php

namespace App\Sync;

use App\Models\Country;
use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use Illuminate\Support\Str;

class UsersToSalesforceSync
{
    public function __construct(private SalesForceRepository $repository) {}

    public function sync()
    {
        $this->repository->authenticate();

        // TODO: soft delete users
        $users = User::where('updated_at', '>=', now()->subDay())->get();

        foreach ($users as $user) {
            $phone = $this->formatPhone($user->phone);

            $values = array_filter([
                'Email' => $user->email,
                'OT_user_id__c' => $user->id,
                'Phone' => $phone,
                'MailingStreet' => $user->street,
                'MailingPostalCode' => $user->zipCode?->zip_code,
                'MailingCity' => $user->zipCode?->name,
                'MailingCountry' => $user->country_id ? Country::find($user->country_id)?->name_fr_fr : 'France',
                'LeadSource' => 'Petites annonces',
                'role__c' => 'Annonceur Objectif Terres',
                'Profil_Objectif_Terres__c' => $user->profile ? User::$profiles[$user->profile] : null,
                'Recevoir_les_infos_de_TDL__c' => empty($user->accept_communication) ? 0 : 1,
                'LastName' => $user->name ?: 'Vide',
                'FirstName' => $user->first_name ?: 'Vide',
            ]);

            $this->repository->upsert('Contact', 'OT_user_id__c', $values);
        }
    }

    private function formatPhone($phone)
    {
        $phone = Str::limit(
            preg_replace('/[ .-]/i', '', preg_replace('/(^\+?33 ?0?)/', '0', $phone)),
            10, ''
        );
        if (! preg_match('/^(0|\+33)/', $phone)) {
            $phone = '0'.$phone;
        }

        return $this->isInvalidPhoneNumber($phone) ? null : $phone;
    }

    private function isInvalidPhoneNumber($phone): bool
    {
        $validPatterns = [
            '/^\(\d{3}\) \d{3}-\d{4}$/',
            '/^\+?\d{10,13}$/',
            '/^\d{3}-\d{3}-\d{4}$/',
        ];

        foreach ($validPatterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                return false;
            }
        }

        return true;
    }
}
