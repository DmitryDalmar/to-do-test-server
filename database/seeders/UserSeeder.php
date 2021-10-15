<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use DB;
use App\Models\User\User;

class UserSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        User::factory()
            ->count(25)
            ->create();

        DB::commit();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
