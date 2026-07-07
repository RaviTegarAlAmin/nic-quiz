<?php

namespace App\Support\Mapper;

use Illuminate\Support\Collection;

final class Mapper
{
    public static function toArray(mixed $data): array
    {
        if ($data === null) {
            return [];
        }

        if ($data instanceof Collection) {
            return $data->toArray();
        }

        if (is_object($data)) {
            return (array) $data;
        }

        return array_map(
            static fn (mixed $row) => is_object($row) ? (array) $row : $row,
            $data
        );
    }

    public static function toSingleArray(mixed $data): array
    {
        if ($data === null) {
            return [];
        }

        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        if (is_object($data)) {
            return (array) $data;
        }

        $row = $data[0] ?? null;

        if ($row === null) {
            return [];
        }

        return is_object($row) ? (array) $row : $row;
    }
}
