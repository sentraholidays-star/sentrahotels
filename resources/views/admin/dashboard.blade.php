<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sentra Hotels</title>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 20px; color: #15120e; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e4ded6; padding-bottom: 20px; margin-bottom: 20px; }
        h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f4efe6; }
        .btn { padding: 8px 16px; text-decoration: none; color: white; border-radius: 4px; display: inline-block; border: none; cursor: pointer; font-size: 14px; }
        .btn-add { background: #23372f; margin-bottom: 10px; }
        .btn-edit { background: #b88746; }
        .btn-delete { background: #dc3545; }
        img { border-radius: 4px; object-fit: cover; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Dashboard - Pilihan Destinasi Premium</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-delete">Logout</button>
            </form>
        </div>
        
        <a href="{{ route('admin.destination.create') }}" class="btn btn-add">+ Tambah Destinasi Baru</a>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Kota/Destinasi</th>
                <th>Preview Gambar</th>
                <th>Aksi</th>
            </tr>
            @foreach($destinations as $index => $dest)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $dest->name }}</strong></td>
                <td><img src="{{ $dest->image_url }}" width="100" height="60" alt="Preview"></td>
                <td>
                    <a href="{{ route('admin.destination.edit', $dest->id) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('admin.destination.destroy', $dest->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus destinasi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>