<?php declare(strict_types=1);

namespace jeremiahwinsley\framework;

function array_sort($array, $on, $order = SORT_ASC)
{
    $new = [];
    $sortable = [];

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable[$k] = $v2;
                    }
                }
            } else {
                $sortable[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable);
                break;
            case SORT_DESC:
                arsort($sortable);
                break;
        }

        foreach ($sortable as $k => $v) {
            $new[$k] = $array[$k];
        }
    }

    return $new;
}

function uuid4()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function slugify($string)
{
    return strtolower(trim(preg_replace('/[^\w\d-]+/', '-', $string)));
}

function format_bytes($bytes, $precision = 2)
{
    $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}