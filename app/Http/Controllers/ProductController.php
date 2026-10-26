<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('status', true);

        // Pencarian nama produk
        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        // Filter harga minimum
        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        // Filter harga maksimum
        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        $products = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories'
        ));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')
        ->where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}