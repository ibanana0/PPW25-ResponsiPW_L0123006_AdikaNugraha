<x-layout>
    
    {{-- Menampilkan pesan status dari session --}}
    @if (session('status'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
    {{-- Header Halaman dan Tombol Tambah --}}
    <div class="flex justify-between items-center my-6">
        <button type="button" data-modal-toggle="create-modal" class="px-4 py-2 bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-opacity-75">
            Tambah Tugas
        </button>
    </div>
    
    {{-- Daftar Kartu Tugas --}}
    <div class="space-y-4">
        @forelse ($todos as $todo)
            <x-card :todo="$todo" />
        @empty
            <p class="text-center text-gray-500">Belum ada tugas yang ditambahkan.</p>
        @endforelse
    </div>
    
    {{-- MODAL UNTUK CREATE TUGAS BARU --}}
    <div id="create-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="create-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Tambah Tugas Baru</h3>
                    <form class="space-y-6" action="{{ route('todos.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                            <input type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="time" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                                <input type="time" name="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                        </div>
                        <div>
                            <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea name="bio" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Tugas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
