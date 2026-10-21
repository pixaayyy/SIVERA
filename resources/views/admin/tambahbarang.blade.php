@extends('layouts.sidebar.admin')

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

    /* Style untuk wrapper select kategori agar tombol sejajar */
    .kategori-wrapper {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* Tombol Tambah Kategori di Form */
    .btn-tambah-kat {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }

    .btn-tambah-kat:hover {
        background-color: #059669;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: white;
        padding: 25px;
        border-radius: 10px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: #333;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #888;
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
            <div class="alert-success">{{ session('success') }}</div>
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

        <form action="{{ route('admin.tambahbarang.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Tanggal Masuk <span class="required">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
                </div>
                
               <div class="form-group">
                    <label>Kategori Barang <span class="required">*</span></label>
                    <div class="kategori-wrapper">
                        <select name="kategori_barang" class="form-control" required>
                            <option value="" disabled selected>--Pilih Kategori--</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('kategori_barang') == $kat->id_kategori ? 'selected':'' }}>
                                    {{ $kat->jenis_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-tambah-kat" onclick="openKategoriModal()">+ Kategori</button>
                    </div>
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

<div class="modal-overlay" id="kategoriModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Kelola Kategori Barang</h3>
            <button type="button" class="close-modal" onclick="closeKategoriModal()">&times;</button>
        </div>
        
        <form action="{{ route('admin.kategori.store') }}" method="POST" style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
            @csrf
            <label style="font-size: 13px; color: #555; display: block; margin-bottom: 8px;">Tambah Kategori Baru</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="jenis_kategori" class="form-control" placeholder="Contoh: Monitor..." required style="flex: 1;">
                <button type="submit" class="btn-simpan" style="padding: 8px 15px;">+ Tambah</button>
            </div>
        </form>

        <div>
            <label style="font-size: 13px; color: #555; display: block; margin-bottom: 10px;">Daftar Kategori</label>
            
            <div class="kategori-list" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                @if(count($kategori) > 0)
                    @foreach($kategori as $index => $kat)
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding: 12px 0;">
                            
                            <div style="color: #475569; font-size: 14px;">
                                <span style="margin-right: 15px; color: #94a3b8; width: 20px; display: inline-block;">{{ $index + 1 }}</span>
                                {{ $kat->jenis_kategori }}
                            </div>

                            <form action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kat->jenis_kategori }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 5px; transition: 0.2s;" onmouseover="this.style.color='#b91c1c'" onmouseout="this.style.color='#ef4444'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; color: #94a3b8; padding: 20px 0; font-size: 13px;">Belum ada kategori.</div>
                @endif
            </div>
        </div>
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

    @if(session('success'))
    document.addEventListener("DOMContentLoaded", function() {
        var alertBox = document.querySelector('.alert-success');
            if (alertBox) {
            setTimeout(function() {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                
                setTimeout(function() {
                    alertBox.style.display = 'none';
                }, 500);
            }, 1000); 
        }
    });
    @endif
</script>
@endsection