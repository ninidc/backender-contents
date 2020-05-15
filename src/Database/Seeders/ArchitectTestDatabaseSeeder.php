<?php

namespace Backender\Contents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Backender\Contents\Entities\Language;
use Backender\Contents\Entities\Typology;
use App\Models\Permission;

class ArchitectTestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'Català',
            'iso' => 'ca'
        ]);

        Language::create([
            'name' => 'Español',
            'iso' => 'es'
        ]);

        Language::create([
            'name' => 'English',
            'iso' => 'en'
        ]);


        Model::unguard();

    }
}
