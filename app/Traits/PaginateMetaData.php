<?php

namespace App\Traits;

trait PaginateMetaData
{
    public function getMetaData(\Illuminate\Contracts\Pagination\LengthAwarePaginator $data)
    {
        return [
            "current_page" => $data->currentPage(),
            "last_page"    => $data->lastPage(),
            "per_page"     => $data->perPage(),
            "total"        => $data->total(),
        ];
    }
}