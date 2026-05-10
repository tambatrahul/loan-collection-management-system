<?php

namespace App\Support;

use Illuminate\Http\Request;

final class PaginationHelper
{
    public static function getPerPage(
        Request $request,
        int $default = 15,
        int $max = 100
    ): int {
        $perPage = (int) $request->integer('per_page', $default);

        if ($perPage < 1) {
            $perPage = $default;
        }

        return min($perPage, $max);
    }

    public static function getPage(
        Request $request,
        int $default = 1
    ): int {
        $page = (int) $request->integer('page', $default);

        return max($page, 1);
    }
}