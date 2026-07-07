<?php

namespace App\Support\StringFormatter;

final class NameFormatter
{
    public static function shortenName(?string $name) :string {

        if ($name === null) {
            return '';
        }

        if (str_word_count($name) > 1) {
            return self::makeInitial($name);
        }

        return $name;

    }

    private static function makeInitial(string $name) :string {

        $parts = explode(' ', $name);

        $firstName = array_shift($parts);

        $initial = '';

        foreach ($parts as $part) {
            $initial .= $part[0];
        }

        return $firstName.' '.$initial;
    }
}
