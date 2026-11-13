<?php

namespace App\Repositories\AdNotes;

use App\Models\AdNote;
use App\Models\ProjectDataKey;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 *
 * @property AdNote $entity
 */
class AdNotesRepository extends AbstractRepository implements AdNotesRepositoryInterface
{
    /**
     * @return string
     */
    public function entity()
    {
        return AdNote::class;
    }

    /**
     * Creates a note.
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function create(array $data)
    {
        $adNote = DB::transaction(function () use ($data) {
            $adNote = new AdNote;
            $adNote->fill($data);
            $adNote->save();

            if (isset($data['project_data_key_id'])) {
                $projectDataKey = ProjectDataKey::whereId($data['project_data_key_id'])->with('projectDataValues')->first();
                if ($projectDataKey->projectDataValues->count() > 0) {
                    $projectDataKey->projectDataValues->filter(function ($projectDataValue) use ($data, $adNote) {
                        if ($projectDataValue->value === $data['value']) {
                            $adNote->projectDataValue()->associate($projectDataValue->id);
                            $adNote->save();
                        }
                    });
                }
            }

            return $adNote;
        });

        return $adNote;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function findAllByProjectDataKeyAndAdId(array $data)
    {
        return $this->entity
            ->where('ad_id', '=', $data['ad_id'])
            ->where('project_data_key_id', '=', $data['project_data_key_id'])
            ->orderByDesc('created_at')
            ->with('user')
            ->get();
    }

    /**
     * @return Collection
     */
    public function findAllNotesWithProjectDataKeysByAdId(int $adId)
    {
        /** @var Collection $notes $notes */
        $notes = $this->entity
            ->where('ad_id', '=', $adId)
            ->whereNotNull('project_data_key_id')
            ->with('projectDataKey')
            ->get();

        return $notes;
    }

    /**
     * @return Collection
     */
    public function findAllNotesWithPublicProjectDatKeysByAdId(int $adId)
    {
        /** @var Collection $notes $notes */
        $notes = $this->entity
            ->where('ad_id', '=', $adId)
            ->whereNotNull('project_data_key_id')
            ->whereHas('projectDataKey', function (Builder $query) {
                $query->where('is_public', '=', 1);
            })
            ->with('projectDataKey')
            ->get();

        return $notes;
    }
}
