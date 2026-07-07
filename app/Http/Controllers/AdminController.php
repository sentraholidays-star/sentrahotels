<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class AdminController extends Controller
{
    // Menampilkan Dashboard beserta daftar destinasi (Read)
    public function index() {
        $destinations = Destination::all();
        return view('admin.dashboard', compact('destinations'));
    }

    // Menampilkan Form Tambah Destinasi (Create)
    public function create() {
        return view('admin.create');
    }

    // Menyimpan Data Destinasi Baru ke Database (Store)
    public function store(Request $request) {
        $request->validate([
            'name' => 'required', 
            'image_url' => 'required'
        ]);
        Destination::create($request->all());
        return redirect()->route('admin.dashboard');
    }

    // Menampilkan Form Edit Destinasi (Edit)
    public function edit($id) {
        $destination = Destination::findOrFail($id);
        return view('admin.edit', compact('destination'));
    }

    // Menyimpan Perubahan Edit ke Database (Update)
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required', 
            'image_url' => 'required'
        ]);
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return redirect()->route('admin.dashboard');
    }

    // Menghapus Data Destinasi (Delete)
    public function destroy($id) {
        Destination::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard');
    }
}