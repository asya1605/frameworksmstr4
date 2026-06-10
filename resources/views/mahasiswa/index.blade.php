@extends('layouts.admin.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h3 class="page-title mb-0 text-primary font-weight-bold">
        <i class="mdi mdi-account-card-details menu-icon me-2"></i>Data Mahasiswa
    </h3>
    <button class="btn btn-gradient-primary btn-icon-text font-weight-semibold" data-bs-toggle="modal" data-bs-target="#modalMahasiswa" id="btnTambahMahasiswa">
        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Mahasiswa
    </button>
</div>

<div class="card card-modern shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="mahasiswaTable" class="table table-striped table-hover dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>NFC Serial Number</th>
                        <th>Terdaftar Pada</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $m)
                    <tr id="row-{{ $m->idmahasiswa }}">
                        <td class="font-weight-semibold">{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>
                            @if($m->nfc_serial_number)
                                <span class="badge badge-gradient-success font-weight-medium">
                                    <i class="mdi mdi-nfc me-1"></i>{{ $m->nfc_serial_number }}
                                </span>
                            @else
                                <span class="text-muted font-italic text-small">Belum dikaitkan</span>
                            @endif
                        </td>
                        <td>{{ $m->created_at->format('d M Y H:i') }}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-warning btn-sm btn-edit-mahasiswa me-1" 
                                    data-id="{{ $m->idmahasiswa }}"
                                    data-nim="{{ $m->nim }}"
                                    data-nama="{{ $m->nama }}"
                                    data-nfc="{{ $m->nfc_serial_number }}">
                                <i class="mdi mdi-pencil me-1"></i>Edit
                            </button>
                            <button class="btn btn-outline-danger btn-sm btn-hapus-mahasiswa" 
                                    data-id="{{ $m->idmahasiswa }}"
                                    data-nama="{{ $m->nama }}">
                                <i class="mdi mdi-delete me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Mahasiswa -->
<div class="modal fade" id="modalMahasiswa" tabindex="-1" aria-labelledby="modalMahasiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title font-weight-bold" id="modalMahasiswaLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMahasiswa">
                @csrf
                <input type="hidden" name="idmahasiswa" id="idmahasiswa">
                <div class="modal-body p-4">
                    
                    <!-- Web NFC Warning Info Panel -->
                    <div class="alert alert-nfc-info d-flex align-items-start mb-3" role="alert">
                        <i class="mdi mdi-information-outline text-primary me-2 font-20"></i>
                        <div>
                            <span class="font-weight-semibold text-dark">Informasi Web NFC:</span>
                            <ul class="mb-0 ps-3 text-small text-muted">
                                <li>Wajib menggunakan <strong>Android Chrome</strong>.</li>
                                <li>Wajib dijalankan melalui koneksi aman <strong>HTTPS / ngrok</strong>.</li>
                                <li>Pastikan fitur NFC pada perangkat Android Anda telah <strong>Aktif</strong>.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Input NIM -->
                    <div class="form-group mb-3">
                        <label for="nim" class="form-label font-weight-semibold">NIM (Nomor Induk Mahasiswa)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-account-card-details-outline text-primary"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="nim" name="nim" required placeholder="Masukkan NIM mahasiswa">
                        </div>
                    </div>

                    <!-- Input Nama -->
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label font-weight-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-account text-primary"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <!-- Input NFC Serial Number -->
                    <div class="form-group mb-3">
                        <label for="nfc_serial_number" class="form-label font-weight-semibold">NFC Serial Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-nfc text-primary"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="nfc_serial_number" name="nfc_serial_number" placeholder="Tap kartu atau input manual">
                            <button type="button" class="btn btn-nfc-scan font-weight-semibold" id="btnScanNfc">
                                <i class="mdi mdi-nfc me-1 pulse-icon"></i> Scan NFC
                            </button>
                        </div>
                        <small class="form-text text-muted text-small mt-1">Kosongkan jika kartu belum dikaitkan.</small>
                    </div>

                    <!-- NFC Scan Status Loader -->
                    <div class="nfc-scan-status-container d-none text-center p-3 rounded-3 mb-2">
                        <div class="spinner-grow text-primary spinner-grow-sm mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 text-primary font-weight-semibold" id="nfcStatusText">Mendekatkan kartu NFC ke HP Anda...</p>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="btnCancelScan">Batal Scan</button>
                    </div>

                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light font-weight-semibold" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-gradient-primary font-weight-semibold" id="btnSimpanMahasiswa">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Styling Premium & Glassmorphism */
    .card-modern {
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .glass-modal {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        border-radius: 20px !important;
        overflow: hidden;
    }
    .alert-nfc-info {
        background: rgba(124, 58, 237, 0.08);
        border: 1px dashed rgba(124, 58, 237, 0.3);
        border-radius: 12px;
    }
    .font-20 {
        font-size: 20px;
    }
    .text-small {
        font-size: 12.5px;
    }
    .input-group-text {
        border-color: #e2e8f0;
    }
    .form-control {
        border-color: #e2e8f0;
        height: 46px;
        font-size: 14.5px;
    }
    .form-control:focus {
        border-color: #a78bfa;
        box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.15);
    }
    .btn-nfc-scan {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 0 16px;
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        transition: all 0.3s;
    }
    .btn-nfc-scan:hover {
        background: #6d28d9;
        color: white;
    }
    .nfc-scan-status-container {
        background: rgba(124, 58, 237, 0.08);
        border: 1px solid rgba(124, 58, 237, 0.2);
    }
    .pulse-icon {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .table td {
        vertical-align: middle;
        font-size: 14px;
    }
    .badge-gradient-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #7c3aed, #9333ea);
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #6d28d9, #7c3aed);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
</style>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    const table = $('#mahasiswaTable').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });

    let nfcController = null; // Menyimpan instance AbortController untuk scan NFC

    // Set Modal to Add Mode
    $('#btnTambahMahasiswa').click(function() {
        $('#formMahasiswa')[0].reset();
        $('#idmahasiswa').val('');
        $('#modalMahasiswaLabel').text('Tambah Mahasiswa');
        $('.nfc-scan-status-container').addClass('d-none');
        cancelNfcScan();
    });

    // Edit Button Clicked (Event Delegation)
    $(document).on('click', '.btn-edit-mahasiswa', function() {
        const id = $(this).data('id');
        const nim = $(this).data('nim');
        const nama = $(this).data('nama');
        const nfc = $(this).data('nfc');

        $('#idmahasiswa').val(id);
        $('#nim').val(nim);
        $('#nama').val(nama);
        $('#nfc_serial_number').val(nfc);
        
        $('#modalMahasiswaLabel').text('Edit Mahasiswa');
        $('.nfc-scan-status-container').addClass('d-none');
        cancelNfcScan();

        $('#modalMahasiswa').modal('show');
    });

    // Form Submit (AJAX)
    $('#formMahasiswa').submit(function(e) {
        e.preventDefault();
        
        const id = $('#idmahasiswa').val();
        const url = id ? `/mahasiswa/${id}` : '/mahasiswa';
        const method = id ? 'PUT' : 'POST';
        
        // Disable save button to avoid duplicate clicks
        const btnSave = $('#btnSimpanMahasiswa');
        btnSave.prop('disabled', true).text('Menyimpan...');

        // Custom AJAX payload (handle PUT for Laravel manually if not using FormData)
        const payload = {
            nim: $('#nim').val(),
            nama: $('#nama').val(),
            nfc_serial_number: $('#nfc_serial_number').val(),
            _token: '{{ csrf_token() }}'
        };

        if (id) {
            payload._method = 'PUT';
        }

        $.ajax({
            url: url,
            type: 'POST', // Always POST, Laravel _method will override to PUT if present
            data: payload,
            success: function(response) {
                btnSave.prop('disabled', false).text('Simpan Data');
                $('#modalMahasiswa').modal('hide');
                cancelNfcScan();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                btnSave.prop('disabled', false).text('Simpan Data');
                
                let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).map(err => err.join('<br>')).join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorMsg
                });
            }
        });
    });

    // Hapus Button Clicked
    $(document).on('click', '.btn-hapus-mahasiswa', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Data mahasiswa "${nama}" beserta riwayat absensinya akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/mahasiswa/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $(`#row-${id}`).fadeOut(500, function() {
                                table.row($(this)).remove().draw();
                            });
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus data mahasiswa.'
                        });
                    }
                });
            }
        });
    });

    // --- Web NFC API Implementation ---

    // Tombol Scan NFC diklik
    $('#btnScanNfc').click(async function() {
        // 1. Validasi Web NFC compatibility
        if (!('NDEFReader' in window)) {
            Swal.fire({
                icon: 'warning',
                title: 'Browser Tidak Mendukung Web NFC',
                html: 'Fitur NFC hanya dapat diakses menggunakan browser <strong>Android Chrome</strong> melalui koneksi aman <strong>HTTPS / localhost / ngrok</strong>.',
                confirmButtonColor: '#7c3aed'
            });
            return;
        }

        // Tampilkan Loader UI scanning
        $('.nfc-scan-status-container').removeClass('d-none');
        $('#nfcStatusText').text('Mendekatkan kartu NFC ke bagian belakang perangkat Anda...');

        // Batalkan scan sebelumnya jika ada
        cancelNfcScan();

        nfcController = new AbortController();
        const { signal } = nfcController;

        try {
            const ndef = new NDEFReader();
            await ndef.scan({ signal });
            
            console.log("NDEFReader: Scan started successfully.");

            ndef.onreadingerror = () => {
                $('#nfcStatusText').html('<span class="text-danger">Gagal membaca tag NFC. Silakan coba lagi.</span>');
            };

            ndef.onreading = ({ message, serialNumber }) => {
                console.log(`NDEFReader: Tag read successfully. Serial: ${serialNumber}`);
                
                // Beep Audio Feedback
                playBeepSound();

                // Isi input field
                $('#nfc_serial_number').val(serialNumber);

                // Sembunyikan Loader UI scanning
                $('.nfc-scan-status-container').addClass('d-none');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Kartu Terbaca!',
                    text: `Serial Number: ${serialNumber}`,
                    timer: 1500,
                    showConfirmButton: false
                });

                cancelNfcScan();
            };

        } catch (error) {
            console.error("NFC Scan Error: ", error);
            
            // Sembunyikan status loader
            $('.nfc-scan-status-container').addClass('d-none');

            let errorAlertMsg = 'Gagal mengaktifkan scanner NFC.';
            if (error.name === 'NotAllowedError') {
                errorAlertMsg = 'Izin akses NFC ditolak oleh pengguna/sistem.';
            } else if (error.name === 'NotSupportedError') {
                errorAlertMsg = 'Fitur NFC tidak didukung pada perangkat ini.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal Scan NFC',
                text: errorAlertMsg,
                confirmButtonColor: '#7c3aed'
            });
        }
    });

    // Batal Scan Button click handler
    $('#btnCancelScan').click(function() {
        cancelNfcScan();
        $('.nfc-scan-status-container').addClass('d-none');
    });

    // Fungsi batalkan scan NFC
    function cancelNfcScan() {
        if (nfcController) {
            nfcController.abort();
            nfcController = null;
            console.log("NDEFReader: Scan aborted.");
        }
    }

    // Nada Beep Digital menggunakan Web Audio API (tidak perlu file audio statis)
    function playBeepSound() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.type = 'sine'; // Tipe suara sine wave
            oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // Frekuensi nada tinggi (880Hz)
            gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime); // Volume sedang
            
            oscillator.start();
            
            // Stop beep setelah 120ms
            gainNode.gain.exponentialRampToValueAtTime(0.00001, audioCtx.currentTime + 0.12);
            oscillator.stop(audioCtx.currentTime + 0.12);
        } catch (err) {
            console.warn("Web Audio API not supported or blocked: ", err);
        }
    }
});
</script>
@endsection
