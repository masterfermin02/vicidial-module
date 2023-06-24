<?php

use Faker;

class BaseSeeder extends \Phinx\Seed\AbstractSeed
{

    const FACTORIES__PATH = ROOT . 'database/factories/';

    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;
    /** @var  \Faker\Generator */
    protected $faker;

    public function init()
    {
        $this->faker = Faker\Factory::create();
    }
}
