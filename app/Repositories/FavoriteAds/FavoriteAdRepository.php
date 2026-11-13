<?php

namespace App\Repositories\FavoriteAds;

use App\Models\Ad;
use App\Models\FavoriteAd;
use App\Models\User;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class FavoriteAdRepository
 *
 * @property FavoriteAd $entity
 */
class FavoriteAdRepository extends AbstractRepository implements FavoriteAdRepositoryInterface
{
    public function entity()
    {
        return FavoriteAd::class;
    }

    public function all($paginate = null)
    {
        return $this->entity
            ->with($this->getEagerLoading())
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Find a Favorite ad by its id.
     *
     * @return FavoriteAd
     */
    public function find($id)
    {

        $model = $this->entity
            ->where(['id' => $id])
            ->with('ad')
            ->first();

        if (! $model) {

            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    /**
     * Find a Favorite ad by the user id.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllByUserId(int $id)
    {
        $model = $this->entity
            ->where('user_id', $id)
            ->whereHas('ad', function (Builder $query) {
                $query->whereHas('userPp', function (Builder $builder) {
                    $builder->whereNull('deleted_at');
                });
            })
            ->with([
                'ad',
                'ad.project',
                'ad.landSeekAd',
                'ad.landOfferAd',
                'ad.jobOfferAd',
                'ad.jobSeekAd',
                'ad.documents',
            ])
            ->get();

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    /**
     * Gets favorite ad by the sf_id AND the ad_id
     *
     * @param array
     * @return FavoriteAd
     */
    public function findByUserAndAdId(array $data)
    {

        $favoriteAd = $this->entity
            ->where('ad_id', $data['ad_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        return $favoriteAd;
    }

    /**
     * Creates an favorite ad.
     *
     * @param array
     *
     * @throws \Throwable
     */
    public function create(array $data): FavoriteAd
    {
        $favoriteAd = new FavoriteAd;
        $favoriteAd->fill($data);
        $favoriteAd->save();

        return $favoriteAd;
    }

    /**
     * Delete an favorite ad.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function destroy(FavoriteAd $favoriteAd)
    {
        return $favoriteAd->delete();

    }
}
