<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 'sell');
        $user = Auth::user();

        if ($page === 'buy') {
            $items = $user->purchases()
                ->with('item')
                ->latest()
                ->get()
                ->pluck('item');
        } else {
            $items = $user->items()->latest()->get();
            $page = 'sell';
        }

        return view('mypage.index', compact('user', 'items', 'page'));
    }
}