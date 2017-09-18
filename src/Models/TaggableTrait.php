<?php

namespace Designbycode\Tagger\Models;

use Designbycode\Tagger\Models\Tag;
use Designbycode\Tagger\Models\TaggableScopeTrait;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait TaggableTrait
{

    use TaggableScopeTrait;


    /**
     * Get tags
     * @return Collection of tags
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * [tag description]
     * @param  Collection $tags
     */
    public function tag($tags)
    {
        $this->addTags($this->getWorkableTags($tags));

    }

    /**
     * [untag description]
     * @param  [type] $tags [description]
     * @return [type]       [description]
     */
    public function untag($tags = null)
    {
        if ( $tags === null){
            $this->removeAllTags();

            return;
        }

        $this->removeTags($this->getWorkableTags( $tags ));
    }

    public function retag($tags)
    {
        $this->removeAllTags();

        $this->tag($tags);
    }

    /**
     * [removeAllTags description]
     * @return [type] [description]
     */
    private function removeAllTags()
    {
        $this->removeTags($this->tags);
    }

    /**
     * [removeTags description]
     * @param  Collection $tags [description]
     * @return [type]           [description]
     */
    private function removeTags(Collection $tags)
    {
        $this->tags()->detach($tags);

        foreach ( $tags->where('count', '>', 0) as $tag ) {
            $tag->decrement('count');
        }
    }

    /**
     * Add tags to collection
     * @param Collection $tags [description]
     */
    private function addTags(Collection $tags)
    {
        $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        foreach ( array_get($sync, 'attached') as $attachedId ){
            $tags->where('id', $attachedId)->first()->increment('count');
        }
    }

    /**
     * [getWorkableTags description]
     * @param  [type] $tags [description]
     * @return [type]       [description]
     */
    private function getWorkableTags($tags)
    {
        if (is_array($tags)){
            return $this->getTagModel($tags);
        }

        if ( $tags instanceof Model ){
            return $this->getTagModel([$this->slug]);
        }

        return $this->fillerTagsCollection($tags);

    }

    /**
     * [fillerTagsCollection description]
     * @param  Collection $tags [description]
     * @return [type]           [description]
     */
    private function fillerTagsCollection(Collection $tags)
    {
        return $tags->filter( function ($tag){
            return $tag instanceof Model;
        });
    }

    /**
     * [getTagModel description]
     * @param  array  $tags [description]
     * @return [type]       [description]
     */
    private function getTagModel(array $tags)
    {
        return Tag::whereIn('slug', $this->normilizeTagName($tags))->get();
    }

    /**
     * [normilizeTagName description]
     * @param  array  $tags [description]
     * @return [type]       [description]
     */
    private function normilizeTagName(array $tags)
    {
        return array_map(function($tag){
            return str_slug($tag);
        }, $tags);
    }




}
