@extends('layouts.vendor.vendor')

@section('title', 'Tambah Menu')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body, .vendor-content { font-family: 'Plus Jakarta Sans', sans-serif; }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--vp-deeper);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-title-pill {
        width: 5px;
        height: 26px;
        background: var(--vp-main);
        border-radius: 4px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid #e5e1f8;
        background: #fff;
        transition: background 0.15s;
    }
    .btn-back:hover { background: #f8f7ff; color: #534ab7; text-decoration: none; }

    /* ── FORM CARD ── */
    .form-card {
        background: #fff;
        border: 1px solid #e5e1f8;
        border-radius: 14px;
        overflow: hidden;
    }
    .form-card-head {
        padding: 16px 24px;
        border-bottom: 1px solid #f3f0fb;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .form-card-icon {
        width: 34px;
        height: 34px;
        background: #eeedfe;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #534ab7;
        font-size: 16px;
        flex-shrink: 0;
    }
    .form-card-label {
        font-size: 13px;
        font-weight: 700;
        color: #1f1a2e;
    }
    .form-card-sub {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 1px;
    }
    .form-body {
        padding: 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    @media (max-width: 600px) {
        .form-body { grid-template-columns: 1fr; }
    }
    .col-full { grid-column: 1 / -1; }

    /* ── FORM ELEMENTS ── */
    .fgroup { display: flex; flex-direction: column; gap: 6px; }
    .flabel { font-size: 12px; font-weight: 600; color: #4b5563; }
    .flabel .req { color: #e24b4a; margin-left: 2px; }
    .fhint { font-size: 11px; color: #9ca3af; }

    .form-control-custom {
        padding: 9px 12px;
        border: 1px solid #e5e1f8;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        color: #1f1a2e;
        background: #fff;
        outline: none;
        transition: border 0.15s, box-shadow 0.15s;
        width: 100%;
    }
    .form-control-custom:focus {
        border-color: #afa9ec;
        box-shadow: 0 0 0 3px #eeedfe;
    }
    .form-control-custom.is-invalid { border-color: #f09595; }

    /* Prefix input (Rp) */
    .input-prefix-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #e5e1f8;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        transition: border 0.15s, box-shadow 0.15s;
    }
    .input-prefix-wrap:focus-within {
        border-color: #afa9ec;
        box-shadow: 0 0 0 3px #eeedfe;
    }
    .input-prefix-tag {
        padding: 9px 12px;
        background: #f8f7ff;
        font-size: 12px;
        font-weight: 600;
        color: #534ab7;
        border-right: 1px solid #e5e1f8;
        white-space: nowrap;
    }
    .input-prefix-wrap input {
        flex: 1;
        border: none;
        outline: none;
        padding: 9px 12px;
        font-size: 13px;
        font-family: inherit;
        color: #1f1a2e;
        background: transparent;
    }

    /* Select */
    .select-custom {
        appearance: none;
        -webkit-appearance: none;
        padding: 9px 34px 9px 12px;
        border: 1px solid #e5e1f8;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        color: #1f1a2e;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%239ca3af'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 10px center;
        outline: none;
        width: 100%;
        transition: border 0.15s, box-shadow 0.15s;
        cursor: pointer;
    }
    .select-custom:focus {
        border-color: #afa9ec;
        box-shadow: 0 0 0 3px #eeedfe;
    }

    /* Upload box */
    .upload-box {
        border: 1.5px dashed #c4bef5;
        border-radius: 10px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        background: #faf9ff;
        transition: background 0.15s;
        text-align: center;
    }
    .upload-box:hover { background: #f3f0ff; }
    .upload-box input[type="file"] { display: none; }
    .upload-icon-wrap {
        width: 38px; height: 38px;
        background: #eeedfe;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        color: #534ab7; font-size: 18px;
    }
    .upload-main-text { font-size: 12px; font-weight: 600; color: #534ab7; }
    .upload-sub-text { font-size: 11px; color: #9ca3af; }
    #foto-preview {
        display: none;
        width: 80px; height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #afa9ec;
    }

    /* Error messages */
    .field-error { font-size: 11px; color: #a32d2d; margin-top: 2px; }

    /* Footer */
    .form-footer {
        padding: 16px 24px;
        border-top: 1px solid #f3f0fb;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-cancel-form {
        padding: 8px 18px;
        border-radius: 8px;
        border: 1px solid #e5e1f8;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        font-family: inherit;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-cancel-form:hover { background: #f3f4f6; color: #374151; text-decoration: none; }
    .btn-save-form {
        padding: 8px 22px;
        border-radius: 8px;
        border: none;
        background: #534ab7;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-save-form:hover { background: #3c3489; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-pill"></span>
        Tambah Menu
    </h3>
    <a href="{{ route('menu.index') }}" class="btn-back">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-card">
        <div class="form-card-head">
            <div class="form-card-icon">
                <i class="mdi mdi-food-fork-drink"></i>
            </div>
            <div>
                <div class="form-card-label">Informasi Menu Baru</div>
                <div class="form-card-sub">Isi detail menu yang akan ditampilkan ke pembeli</div>
            </div>
        </div>

        <div class="form-body">

            {{-- Nama Menu --}}
            <div class="fgroup col-full">
                <label class="flabel">Nama Menu <span class="req">*</span></label>
                <input type="text" name="nama_menu" value="{{ old('nama_menu') }}"
                    class="form-control-custom {{ $errors->has('nama_menu') ? 'is-invalid' : '' }}"
                    placeholder="contoh: Buku" required>
                @error('nama_menu')
                    <span class="field-error">{{ $message }}</span>
                @enderror
                <span class="fhint">Nama yang tampil di daftar menu pembeli</span>
            </div>

            <!-- {{-- Kategori --}}
            <div class="fgroup">
                <label class="flabel">Kategori <span class="req">*</span></label>
                <select name="kategori" class="select-custom {{ $errors->has('kategori') ? 'is-invalid' : '' }}" required>
                    <option value="">Pilih kategori</option>
                    <option value="makanan" {{ old('kategori') === 'makanan' ? 'selected' : '' }}>Makanan Berat</option>
                    <option value="snack"   {{ old('kategori') === 'snack'   ? 'selected' : '' }}>Snack</option>
                    <option value="minuman" {{ old('kategori') === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="dessert" {{ old('kategori') === 'dessert' ? 'selected' : '' }}>Dessert</option>
                </select>
                @error('kategori')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div> -->

            {{-- Harga --}}
            <div class="fgroup">
                <label class="flabel">Harga <span class="req">*</span></label>
                <div class="input-prefix-wrap {{ $errors->has('harga') ? 'is-invalid' : '' }}">
                    <span class="input-prefix-tag">Rp</span>
                    <input type="number" name="harga" value="{{ old('harga') }}"
                        placeholder="0" min="0" required>
                </div>
                @error('harga')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- {{-- Stok --}}
            <div class="fgroup">
                <label class="flabel">Stok Tersedia</label>
                <input type="number" name="stok" value="{{ old('stok') }}"
                    class="form-control-custom" placeholder="kosongkan jika tidak terbatas" min="0">
                <span class="fhint">Opsional — biarkan kosong jika tidak dibatasi</span>
            </div> -->

            <!-- {{-- Deskripsi --}}
            <div class="fgroup">
                <label class="flabel">Deskripsi</label>
                <textarea name="deskripsi" class="form-control-custom" rows="3"
                    placeholder="Deskripsi singkat, bahan-bahan, atau keterangan tambahan..."
                    style="resize:vertical">{{ old('deskripsi') }}</textarea>
            </div> -->

            <!-- {{-- Foto --}}
            <div class="fgroup">
                <label class="flabel">Foto Menu</label>
                <label class="upload-box" for="foto-input">
                    <input type="file" id="foto-input" name="foto" accept="image/*">
                    <img id="foto-preview" src="" alt="preview">
                    <div class="upload-icon-wrap" id="upload-placeholder-icon">
                        <i class="mdi mdi-image-outline"></i>
                    </div>
                    <span class="upload-main-text" id="upload-placeholder-text">Klik untuk unggah foto</span>
                    <span class="upload-sub-text">JPG, PNG — maks. 2 MB</span>
                </label>
                @error('foto')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div> -->

        </div>{{-- /form-body --}}

        <div class="form-footer">
            <a href="{{ route('menu.index') }}" class="btn-cancel-form">Batal</a>
            <button type="submit" class="btn-save-form">
                <i class="mdi mdi-content-save-outline" style="font-size:15px"></i>
                Simpan Menu
            </button>
        </div>
    </div>

</form>

@endsection

@section('script')
<script>
document.getElementById('foto-input').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('foto-preview');
        preview.src = e.target.result;
        preview.style.display = 'block';
        document.getElementById('upload-placeholder-icon').style.display = 'none';
        document.getElementById('upload-placeholder-text').textContent = file.name;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection