<?php

namespace Designbycode\Tagger\Models;

trait TaggableScopeTrait
{
    /**
     * [scopeWithAnyTag description]
     * @param  [type] $query [description]
     * @param  array  $tags  [description]
     * @return [type]        [description]
     */
    public function scopeWithAnyTags( $query, array $tags )
    {
        return $this->hasTags($tags);
    }


    /**
     * [scopeWithAllTag description]
     * @param  [type] $query [description]
     * @param  array  $tags  [description]
     * @return [type]        [description]
     */
    public function scopeWithAllTags( $query, array $tags )
    {
        foreach ( $tags as $tag ) {
            return $this->hasTags([$tag]);
        }

        return $query;
    }

    /**
     * [scopeHasTags description]
     * @param  [type] $query [description]
     * @param  array  $tags  [description]
     * @return [type]        [description]
     */
    public function scopeHasTags( $query, array $tags )
    {
        return $query->whereHas( 'tags', function ( $query ) use ( $tags ) {
            return $query->whereIn( 'slug', $tags );
        });
    }


}
