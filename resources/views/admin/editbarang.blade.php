@extends('layouts.sidebar.admin')

@section('content')
<style>
    .editbarang-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 30px;
    }
    .form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #dbe4f0;
        border-radius: 8px;
        font-size: 14px;
        color: #334155;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #3b82f6;
    }
    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    .btn-save {
        background-color: #3b82f6;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-save:hover { background-color: #2563eb; }
    
    .btn-cancel {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.2s;
    }
    .btn-cancel:hover { background-color: #f1f5f9; }
</style>

<div class="editbarang-container">
    <div class="form-card">
        <h2 style="margin-top:0; color:#1e293b; margin-bottom: 24px;">Edit Data Barang</h2>
        
        <form action="{{ route('admin.updatebarang', $barang->id_barang) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ $barang->tanggal_masuk }}" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ $barang->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->jenis_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <input type="text" name="tipe" class="form-control" value="{{ $barang->tipe }}" required>
            </div>

            <div class="form-group">
                <label>Ex User</label>
                <input type="text" name="ex_user" class="form-control" value="{{ $barang->ex_user }}">
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <input type="text" name="departemen" class="form-control" value="{{ $barang->departemen }}">
            </div>

            <div class="form-group">
                <label>Nomor Asset</label>
                <input type="text" name="nomor_asset" class="form-control" value="{{ $barang->nomor_asset }}" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status_barang" class="form-control" required>
                    <option value="Ready" {{ $barang->status_barang == 'Ready' ? 'selected' : '' }}>Ready</option>
                    <option value="Rusak" {{ $barang->status_barang == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Perbarui Data</button>
                <a href="{{ route('admin.databarang') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection