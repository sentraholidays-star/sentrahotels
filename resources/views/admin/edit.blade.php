<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Destinasi | Sentra Hotels</title>
    <style>
        body{ font-family: sans-serif; background: #f9f9f9; padding: 20px; } 
        .box{ max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        input { width: 100%; padding: 12px; margin-top: 8px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-update { padding: 12px; background: #b88746; color: white; width: 100%; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .back-link { display: block; margin-top: 20px; text-align: center; color: #6d655c; text-decoration: none; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Edit Data Destinasi</h2>
        <form method="POST" action="{{ route('admin.destination.update', $destination->id) }}">
            @csrf 
            @method('PUT')
            
            <label>Nama Destinasi:</label>
            <input type="text" name="name" value="{{ $destination->name }}" required>
            
            <label>Link Gambar URL:</label>
            <input type="url" name="image_url" value="{{ $destination->image_url }}" required>
            
            <button type="submit" class="btn-update">Simpan Perubahan</button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Batal dan Kembali</a>
    </div>
</body>
</html>