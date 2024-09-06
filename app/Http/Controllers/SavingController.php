<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Plan $plan, Request $request)
    {
        $plan->savings()->create([
            'amount' => $request->amount
        ]);

        return back()->with('succes', 'Sukses menambahkan ' . $request->amount . ' ke ' . $plan->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $_, Saving $saving)
    {
        $saving->delete();
        return back()->with('success', 'Berhasil menghapus simpanan');
    }
}
