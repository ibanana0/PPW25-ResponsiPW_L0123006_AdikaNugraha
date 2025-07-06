<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To Do List</title>
        @vite('resources/css/app.css')
    </head>
    <body class="bg-amber-50 m-8">
        <header class="text-center font-bold text-4xl">
            <h1 class="">Responsi 2 Pemograman Web</h1>
            <h2 class="">My To Do List</h2>
            @auth
                <div class="text-right text-sm">
                    <span>Selamat datang, {{ Auth::user()->name }}</span>
                    
                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                        @csrf
                        <button type="submit" class="underline">Logout</button>
                    </form>
                </div>
            @endauth
        </header>
        <main>
            {{$slot}}
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const body = document.body;

                // --- FUNGSI UNTUK MENGIRIM PERMINTAAN AJAX (Hanya untuk Checkbox) ---
                async function sendRequest(url, options) {
                    // Mengambil token CSRF dari form yang relevan
                    const csrfToken = options.form.querySelector('input[name="_token"]').value;
                    const headers = {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        ...options.headers,
                    };

                    try {
                        const response = await fetch(url, { ...options, headers });
                        if (!response.ok) {
                            throw new Error('Server response was not ok');
                        }
                        return await response.json();
                    } catch (error) {
                        console.error('Fetch Error:', error);
                        alert('Terjadi kesalahan saat memperbarui status tugas.');
                        throw error;
                    }
                }

                body.addEventListener('click', function(event) {
                    // Menangani pembukaan modal
                    const toggleButton = event.target.closest('[data-modal-toggle]');
                    if (toggleButton) {
                        const modalId = toggleButton.getAttribute('data-modal-toggle');
                        const modal = document.getElementById(modalId);
                        if (modal) modal.classList.remove('hidden');
                    }

                    // Menangani penutupan modal
                    const hideButton = event.target.closest('[data-modal-hide]');
                    if (hideButton) {
                        const modalId = hideButton.getAttribute('data-modal-hide');
                        const modal = document.getElementById(modalId);
                        if (modal) modal.classList.add('hidden');
                    }
                });

                body.addEventListener('change', async function(event) {
                    if (!event.target.matches('.todo-checkbox')) return;

                    const checkbox = event.target;
                    const form = checkbox.closest('form');

                    checkbox.disabled = true;

                    try {
                        const data = await sendRequest(form.action, { method: 'PATCH', form: form });
                        if (data.success) {
                            const card = checkbox.closest('.todo-card');

                            // Dapatkan semua elemen yang relevan di dalam kartu
                            const title = card.querySelector('.todo-title');
                            const details = card.querySelector('.todo-details');
                            const bio = card.querySelector('.todo-bio');

                            // Toggle class untuk efek visual pada elemen yang benar
                            card.classList.toggle('opacity-60', data.is_complete);
                            card.classList.toggle('bg-amber-50', data.is_complete);
                            title.classList.toggle('line-through', data.is_complete);
                            details.classList.toggle('line-through', data.is_complete);
                            bio.classList.toggle('line-through', data.is_complete);
                        }
                    } catch (error) {
                        // Jika gagal, kembalikan status checkbox ke semula
                        checkbox.checked = !checkbox.checked;
                    } finally {
                        // Apapun hasilnya, aktifkan kembali checkbox
                        checkbox.disabled = false;
                    }
                });
            });
        </script>
    </body>
</html>
