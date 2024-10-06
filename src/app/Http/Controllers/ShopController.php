<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops=Shop::all();
        /*foreach ($shops as $shop) {
        }*/
        return view('shop_all',compact('shops'));
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function detail(Request $request) {
        $shop = $request->input('shop');
        return view('shop_detail', compact('shop'));
    }
}
