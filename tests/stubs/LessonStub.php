<?php


use Illuminate\Database\Eloquent\Model;
use DesignByCode\Tagger\Models\TaggableTrait;

class LessonStub extends Model
{
    use TaggableTrait;

    protected $fillable = ['title'];

    protected $connection = "testbench";

    public $table = "lessons";





}
