<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Category)->create([
            'name' => 'Without parent',
            'type' => Category::TYPE_LEAF,
        ]);

        (new Category)->create([
            'name' => 'Еда',

            'children' => [
                ['name' => 'Полуфабрикаты оптом', 'type' => Category::TYPE_LEAF],
                ['name' => 'Мясная продукция', 'type' => Category::TYPE_LEAF],
                ['name' => 'Продовольственные магазины', 'type' => Category::TYPE_LEAF],
            ],
        ]);

        (new Category)->create([
            'name' => 'Одежда',

            'children' => [
                ['name' => 'Женская одежда', 'type' => Category::TYPE_LEAF],
                ['name' => 'Мужская одежда', 'type' => Category::TYPE_LEAF],
                ['name' => 'Верхняя одежда', 'type' => Category::TYPE_LEAF],
                ['name' => 'Трикотажные изделия', 'type' => Category::TYPE_LEAF],
            ],
        ]);

        (new Category)->create([
            'name' => 'Автомобили',

            'children' => [
                [
                    'name' => 'Грузовые',

                    'children' => [
                        ['name' => 'Запчасти для подвески', 'type' => Category::TYPE_LEAF],
                        ['name' => 'Шины/Диски', 'type' => Category::TYPE_LEAF],
                    ],
                ],
                [
                    'name' => 'Легковые',

                    'children' => [
                        ['name' => 'Запчасти для подвески', 'type' => Category::TYPE_LEAF],
                        ['name' => 'Шины/Диски', 'type' => Category::TYPE_LEAF],
                    ],
                ],
            ],
        ]);
    }
}
