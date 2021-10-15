<?php

namespace Database\Seeders;

use App\Models\Material\Material;
use App\Models\Material\MaterialColor;
use App\Models\Media\MediaTemp;
use App\Models\Task\Task;
use App\Models\Useful\Useful;
use App\Services\Admin\Material\MaterialColorSaver;
use App\Services\Admin\Material\MaterialSaver;
use App\Services\Admin\Useful\UsefulSaver;
use App\Traits\Seeds\FileUpload;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use DB;
use Image;

class TaskSeeder extends Seeder
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

        Task::factory()
            ->count(25)
            ->create();

        DB::commit();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
