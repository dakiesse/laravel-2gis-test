<?php

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $tree */
        $leaves = (new Category)->allLeaves();

        factory(Company::class, env('SEED_COMPANY_AMOUNT', 10000))
            ->create()
            ->each(function (Company $company) use ($leaves) {
                $countRelation = rand(1, 3); // Random amount of relation with Category
                $randomLeaves = $leaves->random($countRelation);

                // Single or several attach
                if ($randomLeaves instanceof Collection) {
                    $relationIds = $randomLeaves->map(function (Category $company) {
                        return $company->id;
                    })->toArray();
                } else {
                    $relationIds = $randomLeaves->id; // Single
                }

                // Attaching (in pivot table)
                $company->categories()->attach($relationIds);
            });
    }
}
