<?php


namespace DesignByCode\Tagger\Models;


trait TagsUsedScopeTrait
{

    /**
     * [scopeUsedGte description]
     * @param  [type] $query [description]
     * @param  [type] $count [description]
     * @return [type]        [description]
     */
    public function scopeUsedGte($query, $count)
    {
        return $query->where('count', '>=', $count);
    }
    
    /**
     * [scopeUsedGte description]
     * @param  [type] $query [description]
     * @param  [type] $count [description]
     * @return [type]        [description]
     */
    public function scopeUsedGt($query, $count)
    {
        return $query->where('count', '>', $count);
    }

    /**
     * [scopeUsedGte description]
     * @param  [type] $query [description]
     * @param  [type] $count [description]
     * @return [type]        [description]
     */
    public function scopeUsedLte($query, $count)
    {
        return $query->where('count', '<=', $count);
    }

    /**
     * [scopeUsedGte description]
     * @param  [type] $query [description]
     * @param  [type] $count [description]
     * @return [type]        [description]
     */
    public function scopeUsedLt($query, $count)
    {
        return $query->where('count', '<', $count);
    }

}
