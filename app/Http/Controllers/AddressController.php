<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Menampilkan daftar alamat pengguna.
     */
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('addresses.index', compact('addresses'));
    }

    /**
     * Menampilkan form tambah alamat.
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Menyimpan alamat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'postal_code' => ['required', 'string', 'max:10'],
            'is_default' => ['nullable', 'boolean'],
        ], [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
        ]);

        $isDefault = $request->boolean('is_default');

        // Jika belum punya alamat sama sekali,
        // alamat pertama otomatis menjadi alamat utama.
        $hasAddress = Address::where(
            'user_id',
            auth()->id()
        )->exists();

        if (!$hasAddress) {
            $isDefault = true;
        }

        // Jika alamat baru dijadikan utama,
        // alamat lama tidak lagi menjadi utama.
        if ($isDefault) {
            Address::where('user_id', auth()->id())
                ->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => auth()->id(),
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'address' => $validated['address'],
            'postal_code' => $validated['postal_code'],
            'is_default' => $isDefault,
        ]);

        return redirect()
            ->route('addresses.index')
            ->with(
                'success',
                'Alamat berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan form edit alamat.
     */
    public function edit(Address $address)
    {
        $this->checkOwnership($address);

        return view('addresses.edit', compact('address'));
    }

    /**
     * Memperbarui alamat.
     */
    public function update(
        Request $request,
        Address $address
    ) {
        $this->checkOwnership($address);

        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'postal_code' => ['required', 'string', 'max:10'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            Address::where('user_id', auth()->id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update([
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'address' => $validated['address'],
            'postal_code' => $validated['postal_code'],
            'is_default' => $isDefault,
        ]);

        return redirect()
            ->route('addresses.index')
            ->with(
                'success',
                'Alamat berhasil diperbarui.'
            );
    }

    /**
     * Menghapus alamat.
     */
    public function destroy(Address $address)
    {
        $this->checkOwnership($address);

        $wasDefault = $address->is_default;

        $address->delete();

        // Jika alamat utama dihapus,
        // jadikan alamat terbaru sebagai alamat utama.
        if ($wasDefault) {
            $newDefault = Address::where(
                'user_id',
                auth()->id()
            )
                ->latest()
                ->first();

            if ($newDefault) {
                $newDefault->update([
                    'is_default' => true
                ]);
            }
        }

        return back()->with(
            'success',
            'Alamat berhasil dihapus.'
        );
    }

    /**
     * Memastikan alamat milik user yang sedang login.
     */
    private function checkOwnership(Address $address): void
    {
        abort_unless(
            auth()->user()
                ->addresses()
                ->whereKey($address->getKey())
                ->exists(),
            403,
            'Kamu tidak memiliki akses ke alamat ini.'
        );
    }
}