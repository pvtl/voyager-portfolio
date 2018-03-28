<?php

namespace Pvtl\VoyagerPortfolio;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;
use Laravel\Scout\Searchable;

class Portfolio extends Model
{
    use Translatable,
        Searchable;

    public $asYouType = false;

    protected $table = 'portfolio';

    /**
     * Get the indexed data array for the model.
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        // customise the searchable array
        return $array;
    }

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
        'title',
        'slug',
        'status',
        'featured',
        'category_id',
        'image',
        'excerpt',
        'body',
        'testimonial',
        'testimonial_author',
        'meta_title',
        'meta_description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categoryId()
    {
        return $this->belongsTo('Pvtl\VoyagerPortfolio\PortfolioCategories');
    }
}
