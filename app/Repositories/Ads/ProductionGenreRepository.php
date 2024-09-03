<?php namespace App\Repositories\Ads;

use App\Models\ProductionGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * @package App\Repositories\Ads
 * @property ProductionGenre $entity
 */
class ProductionGenreRepository extends AbstractRepository
{
    public function entity()
    {
        return ProductionGenre::class;
    }

    /**
     * @return mixed
     */
    public function all($paginate = null)
    {
        return $this->entity->with('children')->get();
    }

    public function getFlattened()
    {
        $productionGenresWithDepth = ProductionGenre::with('children')
            ->whereNull('parent_id')
            ->where('hidden', 0)
            ->orderBy('name')
            ->get()
            ->map
            ->only(['name', 'id', 'children']);

        $productionGenresFlattened = new Collection();
        foreach($productionGenresWithDepth as $productionGenre) {
            if(count($productionGenre["children"])) {
                /** @var Model $child */
                foreach($productionGenre["children"] as $child) {
                    $child["name"] = $productionGenre["name"]." - ".$child["name"];
                    $productionGenresFlattened[] = $child->only(['name', 'id', 'children', 'hidden']);
                }
            }
            else {
                $productionGenresFlattened[] = $productionGenre;
            }
        }

        return $productionGenresFlattened->where('hidden', 0);
    }
}
