<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city');
            $table->string('street');
            $table->double('build_number');
            $table->point('location');
        });


        DB::statement('CREATE INDEX location_gix ON buildings USING GIST (location);');
//        DB::statement('ALTER TABLE buildings ADD COLUMN location geometry(Point, 4326);');
//        DB::statement('ALTER TABLE buildings ADD COLUMN location geography(Point);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
