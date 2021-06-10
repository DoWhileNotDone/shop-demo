<?php

namespace Demo\Utils;

trait TransformArrayMapper
{
    public function iterate(array $array_to_map, callable $transform) : array
    {
        $mapped = [];

        foreach ($array_to_map as $key => $map_item) {
            $mapped = array_merge_recursive(
                $mapped,
                call_user_func($transform, $map_item, $key),
            );
        }
        
        return $mapped;
    }
}
