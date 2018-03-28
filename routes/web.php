<?php

/**
 * Portfolio module
 */
Route::group([
    'as' => 'voyager-frontend.portfolio.',
    'prefix' => 'portfolio',
    'middleware' => ['web'],
    'namespace' => '\Pvtl\VoyagerPortfolio\Http\Controllers'
], function () {
    Route::get('/', ['uses' => 'PortfolioController@getPosts', 'as' => 'list']);
    Route::get('{slug}', ['uses' => 'PortfolioController@getPost', 'as' => 'post']);
});
