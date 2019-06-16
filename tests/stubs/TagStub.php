<?php


use Illuminate\Database\Eloquent\Model;
use DesignByCode\Tagger\Models\TagsUsedScopeTrait;

class TagStub extends Model
{
    use TagsUsedScopeTrait;

    protected $fillable = ['title'];

    protected $connection = "testbench";

    public $table = "tags";





}
