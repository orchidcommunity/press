<?php

namespace Orchid\Database\Press\Seeds;

use Illuminate\Database\Seeder;

class PressDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class="Orchid\Database\Press\Seeds\PressDatabaseSeeder"
     *
     * run another class
     * php artisan db:seed --class="Orchid\Database\Press\Seeds\MenusTableSeeder"
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //TermsTableSeeder::class,
            //MenusTableSeeder::class,
            //PagesTableSeeder::class,
            //PostsTableSeeder::class,
            //\Orchid\Database\Seeds\SettingsTableSeeder::class,
        ]);
    }
}
