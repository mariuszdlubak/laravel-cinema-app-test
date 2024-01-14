<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCodesController extends Controller
{
    public function index()
    {
        return view(
            'admin.codes.index',
            [
                'codes' => Balance::all()
            ]
        );
    }

    public function create()
    {
        return view('admin.codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:5|max:1000|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        do {
            $generatedCode = strtoupper(Str::random(15));
        } while (Balance::where('code', $generatedCode)->exists());

        $code = new Balance([
            'code' => $generatedCode,
            'value' => $request['value'],
            'active' => 1
        ]);
        $code->save();

        return redirect()->route('admin.codes.index')->with('success', 'Code generated successfully!');
    }
}
