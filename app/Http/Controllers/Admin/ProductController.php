<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pencarian produk.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter kategori.
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter status produk.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'weight' => [
                'required',
                'integer',
                'min:1',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['slug'] = $this->makeUniqueSlug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Memperbarui produk.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'weight' => [
                'required',
                'integer',
                'min:1',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['slug'] = $this->makeUniqueSlug(
            $validated['name'],
            $product->id
        );

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        // Jangan hapus produk yang sudah dipakai dalam transaksi.
        if ($product->orderItems()->exists()) {
            return redirect()
                ->route('admin.products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena sudah terkait pesanan. Nonaktifkan produk jika tidak ingin menjualnya lagi.'
                );
        }

        // Hapus item keranjang yang memakai produk ini.
        $product->cartItems()->delete();

        // Hapus gambar produk.
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Membuat slug unik.
     */
    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'produk';
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}