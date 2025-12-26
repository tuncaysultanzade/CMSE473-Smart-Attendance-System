<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">Student Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <!-- Greeting Section -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-2">Welcome, {{ $student->name }}!</h1>
                    <p class="text-lg text-gray-600">Here is your personalized QR code for attendance.</p>
                </div>

                <!-- QR Code Section -->
                <div class="flex justify-center items-center">
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md w-75 h-75 flex justify-center items-center">
                        <!-- QR Code Container -->
                        <div id="qrCodeContainer" class=""></div>
                    </div>
                </div>

                <!-- Instructions Section -->
                <div class="mt-8 text-center">
                    <p class="text-lg text-gray-600">Show the QR code to mark your attendance.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        // Öğrencinin QR Token'ı
        const qrToken = '{{ $student->qr_token }}';

        // QR kodunu render et
        if (qrToken) {
            // QR kodu oluşturmak için qrcode.js kullanıyoruz
            var qrcode = new QRCode(document.getElementById("qrCodeContainer"), {
                text: qrToken,
                width: 250,
                height: 250
            });
        } else {
            console.error('QR token is missing for this user!');
        }
    </script>
</x-app-layout>
