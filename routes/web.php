<?php

/**
 * Portfolio module
 */
Route::group([
    'prefix' => 'portfolio',
    'middleware' => ['web'],
    'namespace' => '\Pvtl\VoyagerPortfolio\Http\Controllers'
], function () {
    Route::get('/', 'PortfolioController@getPosts');
    Route::get('{slug}', 'PortfolioController@getPost');
});
