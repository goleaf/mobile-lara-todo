<?php

namespace App\Http\Controllers;

use App\Actions\Home\ShowHomePageAction;
use App\Http\Requests\Home\ShowHomePageRequest;
use Illuminate\Contracts\View\View;

class HomePageController extends Controller
{
    public function __invoke(ShowHomePageRequest $request, ShowHomePageAction $action): View
    {
        $request->validated();

        return view('pages.home', $action->handle());
    }
}
