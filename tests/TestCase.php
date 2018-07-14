<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp()
    {
        // TODO: use mysql instead of sqlite.
        // TODO: explode integration testing and local testing to few test-lists.
        parent::setUp();
        Artisan::call('db:seed');
    }
}
