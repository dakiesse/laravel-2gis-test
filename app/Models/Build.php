<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class Build extends Model
{
    use PostgisTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'buildings';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $postgisFields = [
        'location' => Point::class,
    ];

    /**
     * Relationship with Companies.
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
