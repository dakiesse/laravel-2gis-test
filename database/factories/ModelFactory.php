<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Build;
use App\Models\Company;
use Phaza\LaravelPostgis\Geometries\Point;

$factory->define(Build::class, function (Faker\Generator $faker) {
    return [
        'city' => 'Novosibirsk',
        'street' => $faker->streetName,
        'build_number' => $faker->buildingNumber,
        'location' => new Point(
            $faker->latitude(82.61444091796876, 83.36700439453126),
            $faker->longitude(54.866333938349605, 55.18357241563886)
        ),
    ];
});

$factory->define(Company::class, function (Faker\Generator $faker) {
    $phones = [];
    $countPhones = rand(1, 3);

    for ($iter = 1; $iter <= $countPhones; $iter++) {
        $phones[] = $faker->phoneNumber;
    }

    return [
        'build_id' => function () use ($faker) {
            return receiveOrCreateBuild($faker);
        },
        'name' => $faker->company,
        'phones' => $phones,
    ];
});

/**
 * Receive from DB or create new Build and return it id.
 *
 * @param \Faker\Generator $faker
 * @param int              $chance Chance of create new entity.
 *
 * @return int
 */
function receiveOrCreateBuild(Faker\Generator $faker, $chance = 5)
{
    static $isFirst = true;

    $willCreateBuild = $faker->boolean($chance);

    if ($isFirst) { // stupid checker
        $willCreateBuild = true;
        $isFirst = false;
    }

    if ($willCreateBuild) {
        return factory(Build::class)->create()->id;
    }

    $build = (new Build)->orderByRaw('random()')->first()->id;

    return $build;
}
