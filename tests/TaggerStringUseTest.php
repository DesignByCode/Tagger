<?php

class TaggerStringUseTest extends TestCase
{

    protected $lesson;

    public function setUp()
    {
        parent::setUp();

        foreach(['php', 'laravel','css', 'jade', 'cool stuff', 'sass'] as $tag ){
            \TagStub::create([
                'name' => $tag,
                'slug' => str_slug($tag)
            ]);
        }


        $this->lesson = \LessonStub::create([
            'title' => 'Test Lesson'
        ]);
    }


    /** @test */
    public function can_tag_a_lesson()
    {
        $this->lesson->tag(['php', 'laravel','css']);



        $this->assertCount(3, $this->lesson->tags);

        foreach(['laravel', 'css', 'php'] as $tag){
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }

    }


    /** @test */
    public function can_untag_a_lesson()
    {
        $this->lesson->tag(['php', 'laravel','css']);
        $this->lesson->untag(['laravel']);

        $this->assertCount(2, $this->lesson->tags);

        foreach(['php', 'css'] as $tag){
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }

    }


    /** @test */
    public function can_remove_all_tags()
    {
        $this->lesson->tag(['css', 'sass', 'scss']);
        $this->lesson->untag();

        $this->lesson->load('tags');

        $this->assertCount(0, $this->lesson->tags);
    }

    /** @test */
    public function can_retag_lessons_tags()
    {
        $this->lesson->tag(['css', 'sass', 'scss']);
        $this->lesson->retag(['css', 'php', 'laravel']);

        $this->lesson->load('tags');

        $this->assertCount(3, $this->lesson->tags);

        foreach(['css', 'php', 'laravel'] as $tag){
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function non_existing_tags_are_ignored_on_tagging()
    {
        $this->lesson->tag(['css', 'sass', 'scss']);

        $this->assertCount(2, $this->lesson->tags);


        foreach(['css', 'sass'] as $tag){
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }

    }

    /** @test */
    public function inconsistent_tag_case_normalized()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'cool stuff', 'csS']);

        $this->assertCount(4, $this->lesson->tags);

        foreach(['laravel', 'php', 'cool stuff', 'css']as $tag){
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }


    }


}
