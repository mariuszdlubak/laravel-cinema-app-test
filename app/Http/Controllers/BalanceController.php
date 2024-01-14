<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function create()
    {
        return view('balance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = Balance::where('code', $request->code)->where('active', 1)->first();

        if($code) {
            $user = auth()->user();
            $oldBalance = $user->balance;
            $user->update(['balance' => $oldBalance + $code->value]);
            $code->update(['active' => 0]);
            return redirect()->route('movies.index')->with('success', 'You have successfully topped up your account');
        } else {
            return redirect()->back()->with('error', 'Invalid code');
        }
    }
}
