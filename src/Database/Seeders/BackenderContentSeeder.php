<?php

namespace Backender\Contents\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Backender\Contents\Entities\Language;

class BackenderContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Language::create([
            'name' => 'English',
            'iso' => 'en'
        ]);

        Language::create([
            'name' => 'Español',
            'iso' => 'es'
        ]);

        Language::create([
            'name' => 'Français',
            'iso' => 'fr'
        ]);

        User::create([
            'email' => 'admin@bar.com',
            'password' => bcrypt('secret'),
            'firstname' => 'John',
            'lastname' => 'Admin',
        ]);
    }
}
