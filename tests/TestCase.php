<?php

use DesignByCode\Tagger\Providers\TaggerServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{


    protected function getPackageProviders($app)
    {
        return [TaggerServiceProvider::class];
    }

    /**
    * Setup the test environment.
    */
    public function setUp()
    {
        parent::setUp();

        Eloquent::unguard();

        $this->artisan('migrate', [
            "--database" => "testbench",

        ]);
    }

    public function tearDown()
    {
        \Schema::drop('lessons');
    }



    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        \Schema::create('lessons', function($table){
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });


    }






}
