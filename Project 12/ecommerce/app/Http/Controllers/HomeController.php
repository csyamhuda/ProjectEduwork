<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function cart()
    {
        // Dummy data (bisa nanti ganti session/database)
        $cartItems = [
            ['nama' => 'Produk 1', 'harga' => 100000, 'qty' => 2],
            ['nama' => 'Produk 2', 'harga' => 150000, 'qty' => 1],
        ];

        return view('cart', compact('cartItems'));
    }
}