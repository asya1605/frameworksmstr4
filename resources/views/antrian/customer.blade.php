<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ambil Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed, #db2777);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);
        }
        .form-control-glass {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            border-radius: 12px;
            padding: 12px 20px;
        }
        .form-control-glass:focus {
            background: rgba(255,255,255,0.1);
            border-color: #ec4899;
            box-shadow: none;
            color: white;
        }
        .queue-display {
            font-size: 3rem;
            font-weight: 800;
            background: -webkit-linear-gradient(135deg, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .realtime-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 20px;
        }
        .pulse {
            width: 8px; height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes ping {
            75%, 100% { transform: scale(2); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="glass-card text-center">
        <h2 class="fw-bold mb-1">Ambil Antrian</h2>
        <p class="text-white-50 mb-4">Silakan masukkan nama Anda</p>
        
        <div id="form-section">
            <form id="form-antrian">
                @csrf
                <div class="mb-4 text-start">
                    <label class="form-label text-white-50 small fw-bold" for="nama">NAMA LENGKAP</label>
                    <input type="text" class="form-control form-control-glass" id="nama" name="nama" required placeholder="Cth: Budi Santoso">
                </div>
                <button type="submit" class="btn btn-gradient w-100" id="btn-submit">
                    Ambil Nomor Antrian
                </button>
            </form>
        </div>

        <div id="result-section" style="display: none;">
            <p class="text-white-50 mb-1">Nomor Antrian Anda:</p>
            <div class="queue-display" id="my-queue">A-000</div>
            <p class="fs-5 mt-2 fw-bold" id="my-name"></p>
            
            <button class="btn btn-outline-light w-100 mt-4 rounded-3 fw-bold" onclick="location.reload()">
                Ambil Antrian Baru
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- SUBMIT ANTRIAN (AJAX) ---
            const form = document.getElementById('form-antrian');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    console.log("[AJAX] Form submit triggered.");

                    const btn = document.getElementById('btn-submit');
                    const namaInput = document.getElementById('nama');
                    const namaValue = namaInput.value.trim();

                    if (!namaValue) {
                        alert("Nama tidak boleh kosong!");
                        return;
                    }

                    // Start spinner & disable inputs
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                    btn.disabled = true;
                    namaInput.disabled = true;

                    // Get CSRF Token safely
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
                    console.log("[AJAX] Before fetch - CSRF Token valid:", !!csrfToken);

                    try {
                        console.log("[AJAX] Fetching POST request to store antrian...");
                        const response = await fetch('/antrian/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ nama: namaValue })
                        });

                        console.log("[AJAX] Response status received:", response.status);

                        if (!response.ok) {
                            throw new Error(`Server returned error status ${response.status}`);
                        }

                        const data = await response.json();
                        console.log("[AJAX] Response JSON data parsed successfully:", data);

                        if (data.success) {
                            // Reset form and UI elements immediately
                            form.reset();
                            btn.innerHTML = 'Ambil Nomor Antrian';
                            btn.disabled = false;
                            namaInput.disabled = false;

                            document.getElementById('form-section').style.display = 'none';
                            document.getElementById('result-section').style.display = 'block';
                            document.getElementById('my-queue').textContent = data.nomor;
                            document.getElementById('my-name').textContent = namaValue;
                            console.log("[AJAX] Queue registered successfully. Nomor:", data.nomor);
                        } else {
                            alert(data.message || 'Gagal mengambil antrian');
                        }
                    } catch (err) {
                        console.error("[AJAX] Submission failed with error:", err);
                        alert('Terjadi kesalahan jaringan atau server: ' + err.message);
                    } finally {
                        // Stop spinner in any case (success / error)
                        btn.innerHTML = 'Ambil Nomor Antrian';
                        btn.disabled = false;
                        namaInput.disabled = false;
                        console.log("[AJAX] Form submit lifecycle finished.");
                    }
                });
            }
        });
    </script>
</body>
</html>
