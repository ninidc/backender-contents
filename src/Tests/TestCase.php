<?php

namespace Backender\Contents\Tests;

use DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Backender\Contents\Database\Seeders\ArchitectTestDatabaseSeeder;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        // FIX : http://novate.co.uk/supporting-delete-cascade-with-sqlite-and-laravel/
        DB::statement(DB::raw('PRAGMA foreign_keys = ON;'));

        $this->artisan('migrate', [
            '--path' => 'Modules/Architect/Database/Migrations',
        ]);

        $this->artisan('migrate', [
            '--path' => 'Modules/Extranet/Database/Migrations',
        ]);

        $this->artisan('migrate', [
            '--path' => 'database/migrations',
        ]);

        (new ArchitectTestDatabaseSeeder())->run();
    }

    public function tearDown()
    {
        $this->artisan('migrate:rollback', [
            '--path' => 'Modules/Architect/Database/Migrations',
        ]);

        $this->artisan('migrate:rollback', [
            '--path' => 'Modules/Extranet/Database/Migrations',
        ]);

        $this->artisan('migrate:rollback', [
            '--path' => 'database/migrations',
        ]);

        parent::tearDown();
    }
}
