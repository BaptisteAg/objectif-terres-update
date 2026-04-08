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
            'last_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'profile' => $this->getUserProfile($user),
            'on_behalf_of_third_party' => $ad->third_party_ad_user_id !== null,
            'deleted_at' => $user->deleted_at ? $user->deleted_at->copy()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : null,
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

        return $this->filterNullValues($authorData);
    }

    /**
     * Recursively remove null values from array
     *
     * @param array $data
     * @return array
     */
    protected function filterNullValues(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->filterNullValues($value);
            } elseif (is_null($value)) {
                unset($data[$key]);
            }
        }

        return $data;
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

        // Map profile ID to English string key
        $profileMap = [
            1 => 'installation_candidate',
            2 => 'seeking',
            3 => 'farmer_consolidation',
            4 => 'farmer_succession',
            5 => 'owner_sale_rental',
            6 => 'owner_donation_bequest',
            7 => 'other',
        ];

        return $profileMap[$user->profile] ?? null;
    }
}