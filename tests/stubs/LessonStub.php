<?php


use Illuminate\Database\Eloquent\Model;
use Designbycode\Tagger\Models\TaggableTrait;

class LessonStub extends Model
{
    use TaggableTrait;

    protected $fillable = ['title'];

    protected $connection = "testbench";

    public $table = "lessons";





}
