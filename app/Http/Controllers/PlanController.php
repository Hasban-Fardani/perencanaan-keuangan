<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function validasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'title' => 'required|string',
            'target' => 'required|integer',
            'target_date' => 'required|date'
        ]);

        if ($validator->fails())
        {
            abort(back()->with('errors', $validator->errors()));
        }


        return $validator->validated();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['user_id'] = auth()->user()->id;

        // store image
        if ($request->hasFile('image')) {
            $data['image'] = str_replace('public/', '', $request->file('image')->store('public/images'));
        }

        $plan = Plan::create($data);

        return back()->with('succes', 'Sukses membuat plan ' . $plan->title);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Plan $plan)
    {
        return view('plan', ['edit' => $request->edit, 'plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $data = $this->validasi($request);

        // store image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public/images');
        }

        $plan->update($data);

        return redirect()->route('plans.show', $plan)->with('succes', 'Sukses mengedit plan ' . $plan->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        // delete image
        if ($plan->image) {
            Storage::delete($plan->image);
        }

        return back()->with('success', 'Berhasil menghapus plan ' . $plan->title);
    }
}
