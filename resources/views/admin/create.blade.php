<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Destinasi | Sentra Hotels</title>
    <style>
        body{ font-family: sans-serif; background: #f9f9f9; padding: 20px; } 
        .box{ max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        input { width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-save { padding: 12px; background: #23372f; color: white; width: 100%; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .back-link { display: block; margin-top: 20px; text-align: center; color: #6d655c; text-decoration: none; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Tambah Destinasi Baru</h2>
        <form method="POST" action="{{ route('admin.destination.store') }}">
            @csrf
            <label>Nama Destinasi (Contoh: Jakarta):</label>
            <input type="text" name="name" required placeholder="Masukkan nama kota">
            
            <label>Link Gambar URL (Unsplash / lainnya):</label>
            <input type="url" name="image_url" required placeholder="https://images.unsplash.com/...">
            
            <button type="submit" class="btn-save">Simpan Destinasi</button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
    </div>
</body>
</html>