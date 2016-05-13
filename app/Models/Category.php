<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NestedSet;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property Collection children
 * @property int        type
 */
class Category extends Model
{
    use NodeTrait;

    /**
     * Type of node.
     */
    const TYPE_BRANCH = 1;
    const TYPE_LEAF   = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [NestedSet::LFT, NestedSet::RGT, 'pivot'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationship with Company.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_category_pivot', 'category_id');
    }

    public function isLeaf()
    {
        return $this->type === self::TYPE_LEAF;
    }

    /**
     * Get all leaves (end-nodes) of the tree from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function allLeaves()
    {
        $leaves = $this->where('type', self::TYPE_LEAF)->get();

        return $leaves ? $leaves : null;
    }

    public function scopeWhereLeaves($scope, $id)
    {
        /** @var self $category */
        $category = (new static)->where('id', $id)->first();

        if ($category->isLeaf()) {
            $scope->where('category_id', $id);
        } else {
            $categories = (new static)
                ->where(NestedSet::LFT, '>', $category->{NestedSet::LFT})
                ->where(NestedSet::RGT, '<', $category->{NestedSet::RGT})
                ->get();

            $scope->whereIn('id', $categories->pluck('id'));
        }
    }
}
