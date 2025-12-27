<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Attendance Scanner • ID {{ $sessionIdQR->id ?? 'Class Session' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        .qr-reader { border: 4px solid #6366f1; border-radius: 1rem; overflow: hidden; }
        #qr-reader { box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .scan-success { animation: pulse 0.6s ease-out; }
        .status-success { background: linear-gradient(90deg, #10b981, #34d399); }
        .status-error { background: linear-gradient(90deg, #ef4444, #f87171); }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-indigo-50 via-white to-purple-50">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-3xl">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">QR Attendance Scanner</h1>
            <p class="text-lg text-gray-600">Session ID: <span class="font-semibold text-indigo-600">{{ $sessionIdQR->id ?? 'Active Class' }}</span></p>
            <div class="mt-3 inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-medium">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                Scanner Active • Point camera at student QR code
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
                <h2 class="text-2xl font-bold text-center">Scan Student QR Code</h2>
            </div>

            <div class="p-8">
                <div id="qr-reader" class="qr-reader mx-auto"></div>
                <div id="status" class="mt-6 text-center text-lg font-semibold text-white py-4 rounded-xl transition-all duration-500 opacity-0">
                    Ready to scan...
                </div>
            </div>
        </div>
        <div class="mt-8 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center justify-between">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Attendance Recorded
                    </span>
                    <span id="count-badge" class="bg-white/20 px-4 py-1 rounded-full text-sm">0 students</span>
                </h3>
            </div>

            <div class="max-h-96 overflow-y-auto">
                <ul id="scanned-students" class="divide-y divide-gray-100"></ul>
            </div>

            <div class="p-4 bg-gray-50 text-center text-sm text-gray-500" id="empty-state">
                No students scanned yet. Start scanning QR codes!
            </div>
        </div>
        <div class="text-center mt-8 text-gray-500 text-sm">
            <span class="font-semibold text-indigo-600">BETAv0.1</span> • {{ now()->format('D, M j, Y') }}
        </div>
    </div>
</div>

<script>
    const scanned = new Set();
    const scanner = new Html5QrcodeScanner("qr-reader", {
        fps: 10,
        qrbox: { width: 280, height: 280 },
        aspectRatio: 1,
        showZoomSliderIfSupported: true,
        showTorchButtonIfSupported: true,
        defaultZoomValueIfSupported: 2
    }, false);

    scanner.render(onScanSuccess, console.warn);

    function onScanSuccess(token) {
        if (scanned.has(token)) {
            setStatus('Already scanned', 'error');
            playBeep(200, 0.5);
            return;
        }

        scanned.add(token);
        addToList(token);
        updateCount();
        playBeep(800, 0.2);

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('{{ route('api.teacher.qrmark') }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                qr_token: token,
                session_id: {{ $sessionIdQR->id }}
            })
        })
        .then(r => {
            if (!r.ok) throw new Error(`Server error: ${r.status}`);
            return r.json();
        })
        .then(d => {
            if (d.status === 'success') {
                setStatus(d.message || 'Marked present!', 'success');
            } else {
                throw new Error(d.message || 'Failed');
            }
        })
        .catch(e => {
            console.error(e);
            setStatus(e.message || 'Failed to record', 'error');
            removeFromList(token);
            scanned.delete(token);
            updateCount();
        });
    }

    function setStatus(msg, type) {
        const el = document.getElementById('status');
        el.textContent = msg;
        el.className = `mt-6 text-center text-lg font-bold text-white py-5 rounded-xl transition-all duration-500 ${type === 'success' ? 'status-success' : 'status-error'} opacity-100`;
        setTimeout(() => {
            el.className += ' opacity-0';
        }, 3000);
    }

    function addToList(token) {
        const ul = document.getElementById('scanned-students');
        const empty = document.getElementById('empty-state');
        if (empty) empty.remove();

        const li = document.createElement('li');
        li.dataset.token = token;
        li.className = 'px-6 py-5 hover:bg-indigo-50 transition-all duration-200 flex items-center justify-between group';

        li.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    ${scanned.size}
                </div>
                <div>
                    <div class="font-semibold text-gray-800">${token}</div>
                    <div class="text-sm text-gray-500">Marked present just now</div>
                </div>
            </div>
            <svg class="w-6 h-6 text-green-500 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        `;

        ul.prepend(li);
    }

    function removeFromList(token) {
        document.querySelector(`li[data-token="${token}"]`)?.remove();
    }

    function updateCount() {
        document.getElementById('count-badge').textContent = `${scanned.size} student${scanned.size !== 1 ? 's' : ''}`;
    }

    function playBeep(freq = 600, duration = 0.1) {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        oscillator.frequency.value = freq;
        oscillator.type = "square";
        gainNode.gain.value = 0.1;
        oscillator.start();
        oscillator.stop(audioCtx.currentTime + duration);
    }
</script>

</body>
</html>
