<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyCategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_category_pivot', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('category_id');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_category_pivot', function ($table) {
            $table->dropForeign('company_category_pivot_company_id_foreign');
            $table->dropForeign('company_category_pivot_category_id_foreign');
        });

        Schema::dropIfExists('company_category_pivot');
    }
}
