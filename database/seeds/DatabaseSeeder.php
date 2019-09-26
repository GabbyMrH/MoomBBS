<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TopicsTableSeeder::class);  //话题应在回复前执行
        $this->call(RepliesTableSeeder::class);
        $this->call(LinksTableSeeder::class);
    }
}
