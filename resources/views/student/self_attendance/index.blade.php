<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            Active Self Attendances
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="sessions-container">
                    @include('student.self_attendance.partials.table', ['sessions' => $sessions])
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshSessions() {
            fetch('{{ route("student.self_attendance") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.querySelector('#sessions-container').innerHTML = html;
            });
        }

        setInterval(refreshSessions, 10000);

        function markAttendance(sessionId) {
            fetch('{{ route("student.self_attendance.mark") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ session_id: sessionId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Attendance Marked!');
                    refreshSessions();
                }
            });
        }
    </script>
</x-app-layout>
