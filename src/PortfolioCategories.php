<?php

namespace Pvtl\VoyagerPortfolio;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class PortfolioCategories extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentId()
    {
        return $this->belongsTo('Pvtl\VoyagerPortfolio\PortfolioCategories');
    }

    /**
     * Update the portfolio item slug
     *
     * @param  string  $value
     * @return string
     */
    public function getSlugAttribute($value)
    {
        if (!empty($value)) {
            return 'portfolio-category/' . $value;
        }
    }
}
