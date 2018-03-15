<?php

namespace Pvtl\VoyagerPortfolio\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Pvtl\VoyagerPortfolio\Page;
use Illuminate\Support\Facades\URL;
use Pvtl\VoyagerPortfolio\Portfolio;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class PortfolioController extends BaseVoyagerBreadController
{
    public function index(Request $request)
    {
        return redirect('/admin/portfolio');
    }
}
