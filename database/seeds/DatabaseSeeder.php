<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        DB::commit();
    }
}
