<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Menampilkan menu untuk pelanggan
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search'); // Ambil input pencarian

        $query = Product::query();

        // Filter berdasarkan Kategori
        if ($category && $category !== 'semua') {
            $query->where('type', $category);
        }

        // Filter berdasarkan Nama (Pencarian)
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $products = $query
            ->select(['id', 'name', 'price', 'type', 'description', 'composition', 'images', 'model_3d'])
            ->simplePaginate(30)
            ->withQueryString();

        return view('order.index', compact('products'));
    }
}
