<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'phones' => 'array',
    ];

    /**
     * Relationship with Build.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function build()
    {
        return $this->belongsTo(Build::class);
    }


    /**
     * Relationship with Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'company_category_pivot', 'company_id');
    }

    /**
     * @param float $lat    Latitude
     * @param float $lng    Longitude
     * @param float $radius Radius of point
     *
     * @return \App\Models\Company
     */
    public function whereBuildingInGisCircle($lat, $lng, $radius)
    {
        $statement = sprintf(
            'ST_DWithin(location::geometry, ST_GeomFromText(\'POINT(%s %s)\', 4326), 0.000009009009009 * %s)',
            $lat, $lng, $radius
        );

        return $this->whereHas('build', function ($q) use ($statement) {
            $q->whereRaw($statement);
        });
    }

    /**
     * @param float $ltlat Left-Top Latitude
     * @param float $ltlng Left-Top Longitude
     * @param float $rblat Right-Bottom Latitude
     * @param float $rblng Right-Bottom Longitude
     *
     * @return \App\Models\Company
     */
    public function whereBuildingInGisRectangle($ltlat, $ltlng, $rblat, $rblng)
    {
        $statement = sprintf(
            'ST_Contains(ST_SetSRID(ST_MakeBox2D(ST_Point(%s, %s), ST_Point(%s, %s)), 4326), location::geometry)',
            $ltlat, $ltlng, $rblat, $rblng
        );

        return $this->whereHas('build', function ($q) use ($statement) {
            $q->whereRaw($statement);
        });
    }

    /**
     * @param array $queries
     *
     * @return \App\Models\Company
     */
    public function search(array $queries)
    {
        $self = $this;

        foreach ($queries as $paramName => $paramValue) {
            if (!$paramValue) {
                continue;
            }

            switch ($paramName) {
                case 'id':
                case 'build_id':
                    $self = $self->where($paramName, $paramValue);
                    break;
                case 'category_id':
                    $self = $self->whereHas('categories', function ($q) use ($paramValue) {
                        $q->whereLeaves($paramValue);
                    });
                    break;
                case 'name':
                    $self = $self->where('name', 'ilike', "%$paramValue%");
            }
        }

        return $self;
    }
}
