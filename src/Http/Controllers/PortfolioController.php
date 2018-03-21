<?php

namespace Pvtl\VoyagerPortfolio\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Pvtl\VoyagerPortfolio\Portfolio;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class PortfolioController extends BaseVoyagerBreadController
{
    /**
     * Route: Gets all posts and passes data to a view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPosts()
    {
        dd('abcd');
        $posts = Portfolio::where([
                ['status', '=', 'PUBLISHED'],
            ])->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('voyager-frontend::modules/posts/posts', [
            'posts' => $posts,
        ]);
    }

    /**
     * Route: Gets a single post and passes data to a view
     *
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPost($slug)
    {
        $post = Portfolio::where([
                ['slug', '=', $slug],
                ['status', '=', 'PUBLISHED'],
            ])->firstOrFail();

        return view('voyager-frontend::modules/portfolio/post', [
            'post' => $post,
        ]);
    }

    /**
     * Recent posts widget
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recentBlogPosts($numPosts = 4)
    {
        $posts = Portfolio::where([
                ['status', '=', 'PUBLISHED'],
            ])->limit($numPosts)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('voyager-frontend::modules/posts/posts-grid', [
            'posts' => $posts,
        ]);
    }
}
