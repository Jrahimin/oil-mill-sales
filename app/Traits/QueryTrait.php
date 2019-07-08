<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait QueryTrait
{
    protected static function filterQuery($request, $query, $whereFilterList=[], $likeFilterList=[])
    {
        foreach ($whereFilterList as $whereFilter)
        {
            if ($request->filled($whereFilter)) {
                $query->where($whereFilter, $request->{$whereFilter});
            }
        }

        foreach ($likeFilterList as $likeFilter)
        {
            if ($request->filled($likeFilter)) {
                $query->where($likeFilter, 'like', '%' . $request->{$likeFilter} . '%');
            }
        }

        return $query;
    }

    protected static function filterDate($query, $column, $from=null, $to=null)
    {
        if($from){
            $query->whereDate($column, '>=', $from);
        }
        if($to){
            $query->whereDate($column, '<=', $to);
        }
        return $query;
    }
}
