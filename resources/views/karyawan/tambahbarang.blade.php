@extends('layouts.sidebar.karyawan')

@section('content')
<style>
    .main-content { 
        flex: 1; 
        display: flex; 
        flex-direction: column; 
    }
    .topbar { 
        background: #fff; 
        padding: 15px 30px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
    }
    .topbar h2 { 
        margin: 0; 
        font-size: 20px; 
        color: #333; 
    }
    .topbar-right { 
        display: flex; 
        align-items: center; 
        gap: 15px; 
    }
    .date-badge { 
        padding: 8px 15px; 
        background: #fff; 
        border: 1px solid #ddd; 
        border-radius: 20px; 
        font-size: 12px; 
        color: #555; 
    }
    .notification { 
        font-size: 20px; 
        color: #888; 
        position: relative; 
    }
    .notification::after { 
        content: ''; 
        position: absolute; 
        top: 0; 
        right: 0; 
        width: 8px; 
        height: 8px; 
        background: red; 
        border-radius: 50%; 
    }
    .form-container { 
        background: #fff; 
        margin: 30px; 
        padding: 30px; 
        border-radius: 10px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.03); 
    }
    .form-header h3 { 
        margin: 0 0 5px 0; 
        color: #333; 
        font-size: 18px; 
    }
    .form-header p { 
        margin: 0 0 25px 0; 
        color: #888; 
        font-size: 12px; 
    }
    .form-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 20px; 
    }
    .form-group label { 
        display: block; 
        font-size: 12px; 
        color: #555; 
        margin-bottom: 8px; 
    }
    .required { 
        color: red; 
    }
    .form-control { 
        width: 100%; 
        padding: 10px 12px; 
        border: 1px solid #ccc; 
        border-radius: 6px; 
        font-size: 13px; 
        box-sizing: border-box; 
        outline: none; 
        transition: 0.3s; 
    }
    .form-control:focus { 
        border-color: #38b6ff; 
    }

    .button-group { 
        display: flex; 
        justify-content: flex-end; 
        gap: 15px; 
        margin-top: 30px; 
    }
    .btn-reset { 
        padding: 10px 30px; 
        background: #fff; 
        border: 1px solid #38b6ff; 
        color: #38b6ff; 
        border-radius: 6px; 
        cursor: pointer; 
        font-weight: 500; 
    }
    .btn-simpan { 
        padding: 10px 30px; 
        background: #55b8eb; 
        border: none; 
        color: #fff; 
        border-radius: 6px; 
        cursor: pointer; 
        font-weight: 500; 
    }
    .btn-simpan:hover { 
        background: #38b6ff; 
    }
    .alert-success { 
        background: #d4edda; 
        color: #155724; 
        padding: 10px; 
        border-radius: 6px; 
        margin-bottom: 20px; 
        font-size: 13px; 
    }
</style>

<div class="main-content">
    <div class="topbar">
        <h2>Tambah Barang Rusak</h2>
        <div class="topbar-right">
            <div class="date-badge"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</div>
            @include('notifikasi')
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h3>Form Input Barang Rusak</h3>
            <p>Masukkan detail aset IT ke dalam inventaris gudang.</p>
        </div>

        @if(session('success'))
            <div class="alert-success" id="success-alert">{{ session('success') }}</div>
            <script>
                setTimeout(function() {
                    var alertBox = document.getElementById('success-alert');
                    if (alertBox) {
                        alertBox.style.transition = 'opacity 0.5s ease';
                        alertBox.style.opacity = '0';
                        setTimeout(function() {
                            alertBox.remove(); // Menghapus elemen dari HTML
                        }, 500); // Tunggu animasi pudar selesai
                    }
                }, 1000); // Tampil 1 detik
            </script>
        @endif

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('karyawan.tambahbarang.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Tanggal Masuk <span class="required">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
                </div>
                
               <div class="form-group">
                    <label>Kategori Barang <span class="required">*</span></label>
                    <select name="kategori_barang" class="form-control" required>
                        <option value="" disabled selected>--Pilih Kategori--</option>
                        @foreach ($kategori as $kat )
                            <option value="{{ $kat->id_kategori }}" {{ old('kategori_barang') == $kat->id_kategori ? 'selected':'' }}>
                                {{ $kat->jenis_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Barang <span class="required">*</span></label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop" value="{{ old('nama_barang') }}" required>
                </div>

                <div class="form-group">
                    <label>Ex User</label>
                    <input type="text" name="ex_user" class="form-control" placeholder="Contoh: Budi (IT)" value="{{ old('ex_user') }}">
                </div>

                <div class="form-group">
                    <label>Tipe <span class="required">*</span></label>
                    <input type="text" name="tipe" class="form-control" placeholder="Contoh: Dell OptiPlex 7080, Core i7" value="{{ old('tipe') }}" required>
                </div>

                <div class="form-group">
                    <label>Departemen</label>
                    <input type="text" name="departemen" class="form-control" placeholder="Contoh: Commrel" value="{{ old('departemen') }}">
                </div>

                <div class="form-group">
                    <label>Status Barang <span class="required">*</span></label>
                    <select name="status_barang" class="form-control" required>
                        <option value="Rusak" {{ old('status_barang') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Ready" {{ old('status_barang') == 'Ready' ? 'selected' : '' }}>Ready</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor Asset <span class="required">*</span></label>
                    <input type="number" name="nomor_asset" class="form-control" placeholder="Hanya Angka (Contoh: 109)" value="{{ old('nomor_asset') }}" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Unit <span class="required">*</span></label>
                    <input type="number" name="jumlah_unit" class="form-control" placeholder="1" min="1" value="{{ old('jumlah_unit') }}" required>
                </div>
            </div>

            <div class="button-group">
                <button type="reset" class="btn-reset">Reset</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openKategoriModal() {
        document.getElementById('kategoriModal').classList.add('active');
    }

    function closeKategoriModal() {
        document.getElementById('kategoriModal').classList.remove('active');
    }

    window.onclick = function(event) {
        var modal = document.getElementById('kategoriModal');
        if (event.target == modal) {
            closeKategoriModal();
        }
    }
</script>
@endsection