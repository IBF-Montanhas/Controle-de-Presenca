<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class EasyCollection
{
    /**
     * function make
     *
     * @param mixed $data
     * @param mixed ...$dataToMerge
     *
     * @return Collection|null
     */
    public static function make(mixed $data, mixed ...$dataToMerge): ?Collection
    {
        if (!$data || \is_object($data) && $data instanceof Collection) {
            return static::mergeWithColection(\collect($data), ...$dataToMerge);
        }

        $data = \is_array($data) ? \collect($data) : $data;

        $validToCast = \is_string($data);

        if (!$validToCast) {
            return static::mergeWithColection(\collect($data), ...$dataToMerge);
        }

        $result = AsCollection::castUsing([
            Collection::class
        ])->get(
            '',
            'data',
            '',
            [
                'data' => $data
            ]
        ) ?: \collect();

        return static::mergeWithColection($result, ...$dataToMerge);
    }

    /**
     * function mergeWithColection
     *
     * @param Collection|null $collection
     * @param mixed ...$dataToMerge
     *
     * @return Collection
     */
    public static function mergeWithColection(
        ?Collection $collection = null,
        mixed ...$dataToMerge
    ): Collection {
        $collection = $collection ?: \collect();

        foreach ($dataToMerge as $data) {
            $collection = $collection->merge($data);
        }

        return $collection;
    }
}
