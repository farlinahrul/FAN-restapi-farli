<?php

namespace App\Traits;

trait PaginateRules
{
    public function getRules()
    {
        return [
            'per_page'     => ['numeric'],
            'current_page' => ['numeric'],
            'q'            => [],
            'order'        => ['in:asc,desc'],
            'order_by'     => []
        ];
    }
}