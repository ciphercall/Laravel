<?php

use Vinkla\Hashids\Facades\Hashids;

function az_hash($val, $connection = null)
{
    return Hashids::connection($connection ?? 'main')->encode($val);
}

function az_unhash($hash, $connection = null)
{
    $d = Hashids::connection($connection ?? 'main')->decode($hash);
    return array_key_exists(0, $d) ? $d[0] : null;
}

function az_slug($string, $separator = '-')
{
    $slug = mb_strtolower(
        preg_replace('/([?]|\p{P}|\s)+/u', $separator, $string)
    );
    return trim($slug, $separator);
}

function az_is_dhaka($city_id)
{
    // DHaka as main city
    // return in_array($city_id, [98, 99]);

    // Chittagong as main city
    return in_array($city_id, [32, 33]);
}
