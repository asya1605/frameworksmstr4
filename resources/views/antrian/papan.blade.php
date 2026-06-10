<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .pulse {
            width: 12px; height: 12px;
            background: #10b981;
            border-radius: 50%;
            animation: ping 1.5s infinite;
        }
        @keyframes ping {
            75%, 100% { transform: scale(2); opacity: 0; }
        }
        .main-content {
            flex: 1;
            display: flex;
            padding: 40px;
            gap: 40px;
        }
        .current-queue-box {
            flex: 2;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(219, 39, 119, 0.1));
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            transition: background 0.5s ease;
        }
        .current-queue-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #7c3aed, #ec4899);
        }
        .lbl-dipanggil {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 4px;
            color: #ec4899;
            text-transform: uppercase;
        }
        .number-huge {
            font-size: 14rem;
            font-weight: 900;
            line-height: 1;
            margin: 20px 0;
            background: -webkit-linear-gradient(135deg, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .name-large {
            font-size: 3.5rem;
            font-weight: 700;
            color: #94a3b8;
        }
        .list-box {
            flex: 1;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 32px;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        .list-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .queue-item {
            background: rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .q-num {
            font-size: 2rem;
            font-weight: 800;
            color: white;
        }
        .q-name {
            font-size: 1.2rem;
            color: #94a3b8;
        }
        
        .anim-flash {
            animation: flash 1s ease-out;
        }
        @keyframes flash {
            0% { background: rgba(236, 72, 153, 0.4); }
            100% { background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(219, 39, 119, 0.1)); }
        }
    </style>
</head>
<body>
    <div id="btn-sound-unlock" class="text-center py-3 bg-warning text-dark fw-bold" style="cursor: pointer; z-index: 9999; font-size: 1.1rem; transition: all 0.3s ease-in-out; background: linear-gradient(90deg, #f59e0b, #fbbf24); border-bottom: 2px solid #d97706; display: block;" onclick="unlockSound()">
        📢 Browser membatasi pemutaran suara. Klik di sini untuk <strong>Aktifkan Suara Papan Antrian</strong>.
    </div>

    <div class="header">
        <h2 class="m-0 fw-bold">SISTEM ANTRIAN</h2>
        <div class="d-flex align-items-center gap-2">
            <div class="pulse"></div>
            <span class="fw-bold text-success">REALTIME CONNECTED</span>
        </div>
    </div>

    <div class="main-content">
        <div class="current-queue-box" id="main-display">
            <div class="lbl-dipanggil">Nomor Antrian</div>
            <div class="number-huge" id="current-queue">---</div>
            <div class="name-large" id="current-name">Silakan Menunggu</div>
        </div>

        <div class="list-box">
            <div class="list-title">Antrian Berikutnya</div>
            <div id="queue-list" style="overflow-y: auto; flex:1;">
                <div class="text-center text-white-50 mt-5 fw-bold">Menunggu data SSE...</div>
            </div>
        </div>
    </div>

    <script>
        const audio = new Audio('/audio/tingtong.mp3');
        // fallback to beep if tingtong is missing
        audio.onerror = () => { audio.src = '/audio/beep.mp3'; }; 
        
        let lastQueue = null;
        let lastTimestamp = null;
        let soundUnlocked = false;

        window.unlockSound = function() {
            console.log("[AUDIO] Unlocking sound APIs...");
            
            // Play tingtong immediately to satisfy user gesture policy
            audio.play().then(() => {
                console.log("[AUDIO] Audio API unlocked successfully.");
                soundUnlocked = true;
                
                // Hide the banner with slide-up effect
                const banner = document.getElementById('btn-sound-unlock');
                if (banner) {
                    banner.style.marginTop = `-${banner.offsetHeight}px`;
                    setTimeout(() => {
                        banner.style.display = 'none';
                    }, 300);
                }

                // TTS unlock verification
                window.speechSynthesis.cancel();
                let speech = new SpeechSynthesisUtterance("Sistem suara antrian aktif");
                speech.lang = 'id-ID';
                speech.rate = 0.85;
                window.speechSynthesis.speak(speech);
            }).catch(err => {
                console.error("[AUDIO] Direct play failed, attempting TTS directly:", err);
                
                window.speechSynthesis.cancel();
                let speech = new SpeechSynthesisUtterance("Sistem suara antrian aktif");
                speech.lang = 'id-ID';
                speech.rate = 0.85;
                window.speechSynthesis.speak(speech);
                
                soundUnlocked = true;
                const banner = document.getElementById('btn-sound-unlock');
                if (banner) {
                    banner.style.marginTop = `-${banner.offsetHeight}px`;
                    setTimeout(() => {
                        banner.style.display = 'none';
                    }, 300);
                }
            });
        }

        const evtSource = new EventSource('/sse/antrian');
        
        evtSource.addEventListener('queue-update', function(e) {
            const data = JSON.parse(e.data);
            
            // Check if there is a new call or a recall (timestamp change)
            if (data.current !== '---' && (data.current !== lastQueue || data.timestamp !== lastTimestamp)) {
                const prevQueue = lastQueue;
                lastQueue = data.current;
                lastTimestamp = data.timestamp;
                
                // Flash animation
                const display = document.getElementById('main-display');
                display.classList.remove('anim-flash');
                void display.offsetWidth; // trigger reflow
                display.classList.add('anim-flash');

                // Only play chime and speak if this is not the initial load of the page
                if (prevQueue !== null) {
                    audio.onended = () => {
                        window.speechSynthesis.cancel();
                        let speech = new SpeechSynthesisUtterance();
                        speech.text = "Nomor antrian " + data.current.replace('-', ' ') + ", silakan menuju loket";
                        speech.lang = 'id-ID';
                        speech.rate = 0.85;
                        window.speechSynthesis.speak(speech);
                    };

                    audio.play().catch(err => {
                        console.log('Audio play blocked. Attempting speech synthesis directly.');
                        window.speechSynthesis.cancel();
                        let speech = new SpeechSynthesisUtterance();
                        speech.text = "Nomor antrian " + data.current.replace('-', ' ') + ", silakan menuju loket";
                        speech.lang = 'id-ID';
                        speech.rate = 0.85;
                        window.speechSynthesis.speak(speech);
                    });
                }
            }

            document.getElementById('current-queue').textContent = data.current;
            document.getElementById('current-name').textContent = data.current_name;

            // Render list
            const listContainer = document.getElementById('queue-list');
            listContainer.innerHTML = '';
            
            const waitingList = data.list.filter(item => item.status === 'menunggu');
            
            if (waitingList.length === 0) {
                listContainer.innerHTML = '<div class="text-center text-white-50 mt-5 fw-bold">Tidak ada antrian</div>';
            } else {
                waitingList.slice(0, 5).forEach(item => {
                    listContainer.innerHTML += `
                        <div class="queue-item">
                            <div class="q-num">${item.nomor_antrian}</div>
                            <div class="q-name">${item.nama}</div>
                        </div>
                    `;
                });
            }
        });

        evtSource.onerror = function(err) {
            console.error("SSE Error:", err);
        };

        window.addEventListener('beforeunload', function() {
            if (evtSource) {
                evtSource.close();
            }
        });
    </script>
</body>
</html>
