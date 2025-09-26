<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Ad $ad */
        $ad = $this->resource;

        // Load relationships if not already loaded
        if (!$ad->relationLoaded('userPp')) {
            $ad->load('userPp');
        }

        $user = $ad->userPp;

        if (!$user) {
            return null;
        }

        $authorData = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'profile' => $this->getUserProfile($user),
            'on_behalf_of_third_party' => $ad->third_party_ad_user_id !== null,
        ];

        // Add third party information if exists
        if ($ad->third_party_ad_user_id) {
            if (!$ad->relationLoaded('thirdPartyAdUser')) {
                $ad->load('thirdPartyAdUser');
            }

            if ($ad->thirdPartyAdUser) {
                $authorData['third_party'] = [
                    'id' => $ad->thirdPartyAdUser->id,
                    'first_name' => $ad->thirdPartyAdUser->first_name,
                    'last_name' => $ad->thirdPartyAdUser->last_name,
                    'email' => $ad->thirdPartyAdUser->email,
                    'phone' => $ad->thirdPartyAdUser->phone,
                ];
            }
        }

        return $authorData;
    }

    /**
     * Get the user profile in the specified format
     *
     * @param User $user
     * @return string|null
     */
    protected function getUserProfile($user)
    {
        if (!$user->profile) {
            return null;
        }

        // Map profile ID to string key
        $profileMap = [
            1 => 'candidat_installation',
            2 => 'en_recherche',
            3 => 'agriculteur_consolidation',
            4 => 'agriculteur_transmission',
            5 => 'proprietaire_vente_location',
            6 => 'proprietaire_don_legs',
            7 => 'autre',
        ];

        return $profileMap[$user->profile] ?? null;
    }
}