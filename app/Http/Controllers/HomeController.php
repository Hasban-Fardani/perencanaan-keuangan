<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application Home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $plans = Plan::query()
            ->withSum('savings', 'amount')  # get sums of saved amounts
            ->where('user_id', auth()->user()->id)  # get plans only for current logged user
            ->when($request->status == 'selesai', function ($query) {
                return $query->where('target_date', '<', now());
            })
            ->latest()  # order by latest created
            ->get();  # get the data

        return view('home', compact('plans'));
    }
}
