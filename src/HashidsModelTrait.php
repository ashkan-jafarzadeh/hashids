<?php

namespace Hashids;

use Illuminate\Database\Eloquent\Builder;

trait HashidsModelTrait
{

    /**
     * add a select by hashid to the query builder.
     *
     * @param Builder $builder
     * @param array   $hashids
     *
     * @return void
     */
    public function scopeWithHashids(Builder $builder, $hashids)
    {
        $builder->whereIn('id', (array)hashid_number($hashids));
    }



    /**
     * get Hashid accessor.
     *
     * @return string
     */
    public function getHashidAttribute()
    {
        return hashid($this->id);
    }
}
