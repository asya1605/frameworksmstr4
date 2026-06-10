@extends('layouts.admin.app')

@section('style')
<style>
    /* Purple Glassmorphism & Premium Design */
    .glass-card-active {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(124, 58, 237, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(124, 58, 237, 0.05);
        transition: all 0.3s ease;
    }
    
    .glass-card-history {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(219, 39, 119, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(219, 39, 119, 0.05);
        transition: all 0.3s ease;
    }
    
    .header-card {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        border-radius: 20px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.25);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .header-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .queue-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .queue-card:hover {
        border-color: #7c3aed;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.1);
    }
    
    .queue-card.active-calling {
        border-left: 5px solid #7c3aed;
        background: linear-gradient(90deg, rgba(124, 58, 237, 0.03) 0%, rgba(255, 255, 255, 0.9) 100%);
    }
    
    .q-number {
        font-size: 1.7rem;
        font-weight: 800;
        background: linear-gradient(135deg, #7c3aed, #db2777);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        width: 110px;
        letter-spacing: -0.5px;
    }
    
    .q-name {
        font-weight: 700;
        font-size: 1.15rem;
        color: #1e293b;
        flex: 1;
    }

    .badge-status-modern {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.5px;
    }
    
    .status-menunggu {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .status-dipanggil {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .status-selesai {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .status-terlambat {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .action-btns .btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    
    .action-btns .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* History Table Styling */
    .history-table-container {
        max-height: 480px;
        overflow-y: auto;
    }
    
    .custom-history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    
    .custom-history-table thead th {
        border: none;
        color: #64748b;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.75px;
        padding: 10px 15px;
    }
    
    .custom-history-table tbody tr {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .custom-history-table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(124, 58, 237, 0.05);
    }
    
    .custom-history-table tbody td {
        border: none;
        padding: 15px;
        font-weight: 600;
        color: #334155;
    }
    
    .custom-history-table tbody td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        font-weight: 800;
    }
    
    .custom-history-table tbody td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .durasi-badge {
        background: rgba(124, 58, 237, 0.08);
        color: #7c3aed;
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: 1px solid rgba(124, 58, 237, 0.15);
    }

    .time-badge {
        color: #64748b;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .shadow-modern {
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.05) !important;
    }

    .btn-gradient-purple {
        background: linear-gradient(135deg, #7c3aed, #9333ea);
        color: white;
        border: none;
    }
    .btn-gradient-purple:hover {
        background: linear-gradient(135deg, #6d28d9, #7e22ce);
        color: white;
    }

    .text-purple {
        color: #7c3aed !important;
    }
    
    .btn-outline-purple {
        color: #7c3aed;
        border: 1px solid #7c3aed;
        background: transparent;
        transition: all 0.2s;
    }
    .btn-outline-purple:hover {
        background-color: #7c3aed;
        color: white;
    }
    .btn-glass-purple {
        background: rgba(124, 58, 237, 0.12);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(124, 58, 237, 0.25);
        color: #7c3aed;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .btn-glass-purple:hover {
        background: rgba(124, 58, 237, 0.22);
        border-color: rgba(124, 58, 237, 0.45);
        color: #6d28d9;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="content-wrapper p-0">
    <!-- Header Card -->
    <div class="header-card d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Queue Management</h2>
            <p class="mb-0 opacity-75">Realtime Admin Dashboard (Active Queue + History Log)</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-dark py-2 px-3 rounded-pill d-flex align-items-center gap-2">
                <span class="spinner-grow spinner-grow-sm text-success" role="status"></span>
                SSE ACTIVE
            </span>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="row g-4">
        <!-- Antrian Aktif Realtime -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card-active shadow-modern h-100">
                <div class="card-header border-0 bg-transparent pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="mdi mdi-play-circle-outline text-purple mdi-24px"></i>
                        Antrian Aktif Hari Ini
                    </h4>
                </div>
                <div class="card-body px-4 pb-4" id="queue-container">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 fw-bold">Memuat antrian realtime...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Antrian (History Log) -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card-history shadow-modern h-100">
                <div class="card-header border-0 bg-transparent pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="mdi mdi-history text-pink mdi-24px"></i>
                        Riwayat Antrian (History Log)
                    </h4>
                    <button class="btn btn-sm btn-outline-purple rounded-pill px-3 py-1" onclick="loadHistory()">
                        <i class="mdi mdi-refresh"></i> Refresh
                    </button>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="history-table-container">
                        <table class="table custom-history-table mb-0">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Waktu Selesai</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody id="history-container">
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="spinner-border spinner-border-sm text-purple" role="status"></div>
                                        <p class="mt-2 mb-0">Memuat riwayat...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("[SSE] Initiating EventSource connection to: /sse/antrian");
        const evtSource = new EventSource('/sse/antrian');
        
        evtSource.addEventListener('queue-update', function(e) {
            const data = JSON.parse(e.data);
            renderAdmin(data.list);
        });

        evtSource.onerror = function(err) {
            console.error("[SSE] SSE connection error:", err);
        };

        window.addEventListener('beforeunload', function() {
            if (evtSource) {
                evtSource.close();
            }
        });

        function renderAdmin(list) {
            const container = document.getElementById('queue-container');
            
            if (list.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="mdi mdi-account-multiple-outline mdi-36px text-purple opacity-50 mb-3 d-block"></i>
                        <p class="fw-bold mb-0">Belum ada antrian aktif hari ini.</p>
                    </div>`;
                return;
            }

            let html = '';
            list.forEach(item => {
                const isDipanggil = item.status === 'dipanggil';
                
                html += `
                    <div class="queue-card ${isDipanggil ? 'active-calling shadow-sm' : ''}">
                        <div class="q-number">${item.nomor_antrian}</div>
                        <div class="q-name">
                            ${item.nama}
                            <div class="d-block mt-1">
                                <span class="badge-status-modern ${isDipanggil ? 'status-dipanggil' : 'status-menunggu'}">
                                    <i class="mdi ${isDipanggil ? 'mdi-volume-high' : 'mdi-clock-outline'}"></i> ${item.status}
                                </span>
                            </div>
                        </div>
                        <div class="action-btns gap-2 d-flex">
                            ${!isDipanggil ? 
                                `<button class="btn btn-gradient-primary shadow-sm" onclick="action('${item.idantrian}', 'panggil')">
                                    <i class="mdi mdi-volume-high"></i> Panggil
                                 </button>` 
                                : ''
                            }
                            ${isDipanggil ? 
                                `<button class="btn btn-glass-purple shadow-sm" onclick="action('${item.idantrian}', 'recall')">
                                    <i class="mdi mdi-volume-high"></i> Panggil Ulang
                                 </button>
                                 <button class="btn btn-gradient-success shadow-sm" onclick="action('${item.idantrian}', 'selesai')">
                                    <i class="mdi mdi-check-circle"></i> Selesai
                                 </button>
                                 <button class="btn btn-gradient-danger shadow-sm" onclick="action('${item.idantrian}', 'terlambat')">
                                     <i class="mdi mdi-alert-circle"></i> Terlambat
                                 </button>` 
                                : ''
                            }
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        window.action = function(id, type) {
            fetch(`/admin/antrian/${type}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadHistory(); // Instant UI feedback
                } else {
                    alert('Gagal memproses aksi.');
                }
            })
            .catch(err => alert('Gagal memproses aksi. Cek koneksi Anda.'));
        }

        // --- HISTORY FUNCTIONS ---
        window.loadHistory = function() {
            fetch("{{ route('antrian.history') }}")
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        renderHistory(res.data);
                    }
                })
                .catch(err => {
                    console.error('Error fetching history:', err);
                });
        }

        function renderHistory(list) {
            const container = document.getElementById('history-container');
            
            if (list.length === 0) {
                container.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="mdi mdi-alert-circle-outline mdi-24px text-pink opacity-50 mb-2 d-block"></i>
                            <p class="fw-bold mb-0">Belum ada riwayat antrian hari ini.</p>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            list.forEach(item => {
                let statusBadge = '';
                if (item.status === 'dipanggil') {
                    statusBadge = `<span class="badge-status-modern status-dipanggil"><i class="mdi mdi-volume-high"></i> Dipanggil</span>`;
                } else if (item.status === 'selesai') {
                    statusBadge = `<span class="badge-status-modern status-selesai"><i class="mdi mdi-check-circle"></i> Selesai</span>`;
                } else if (item.status === 'terlambat') {
                    statusBadge = `<span class="badge-status-modern status-terlambat"><i class="mdi mdi-close-circle"></i> Terlambat</span>`;
                } else {
                    statusBadge = `<span class="badge-status-modern status-menunggu"><i class="mdi mdi-clock-outline"></i> Menunggu</span>`;
                }

                // Format finished time
                let waktuSelesai = '-';
                if (item.finished_at) {
                    const finishedDate = new Date(item.finished_at);
                    waktuSelesai = `<span class="time-badge"><i class="mdi mdi-clock-outline"></i> ${finishedDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>`;
                }

                // Format durasi
                let durasiDisplay = '-';
                if (item.status === 'selesai') {
                    if (item.durasi !== null && item.durasi !== undefined) {
                        const sec = item.durasi;
                        if (sec < 60) {
                            durasiDisplay = `<span class="durasi-badge"><i class="mdi mdi-timer-outline"></i> ${sec} detik</span>`;
                        } else {
                            const min = Math.floor(sec / 60);
                            const remSec = sec % 60;
                            durasiDisplay = `<span class="durasi-badge"><i class="mdi mdi-timer-outline"></i> ${min}m ${remSec}s</span>`;
                        }
                    } else {
                        durasiDisplay = `<span class="durasi-badge"><i class="mdi mdi-timer-outline"></i> 0 detik</span>`;
                    }
                }

                html += `
                    <tr>
                        <td class="text-purple font-weight-bold">${item.nomor_antrian}</td>
                        <td class="font-weight-bold">${item.nama}</td>
                        <td>${statusBadge}</td>
                        <td>${waktuSelesai}</td>
                        <td>${durasiDisplay}</td>
                    </tr>
                `;
            });
            container.innerHTML = html;
        }

        // Initial load of history log
        loadHistory();
    });
</script>
@endsection
