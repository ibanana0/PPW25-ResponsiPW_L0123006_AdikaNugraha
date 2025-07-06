@props(['todo'])

{{-- Wrapper untuk kartu dan modalnya agar tetap bersama --}}
<div id="todo-wrapper-{{ $todo->id }}">
    {{-- KARTU TUGAS --}}
    <div class="todo-card flex items-start bg-white rounded-lg shadow-md p-4 my-4 border-l-4 border-amber-400 transition-all duration-300 {{ $todo->is_complete ? 'opacity-60 bg-amber-50' : '' }}">
        
        {{-- Checkbox --}}
        <form method="POST" action="{{ route('todos.toggle', $todo->id) }}" class="mr-4 todo-toggle-form">
            @csrf
            @method('PATCH')
            <input
                    type="checkbox"
                    name="is_complete"
                    class="todo-checkbox h-6 w-6 rounded border-gray-300 text-amber-600 focus:ring-amber-500 cursor-pointer"
                    @checked($todo->is_complete)
            >
        </form>
        
        {{-- Konten Utama Kartu --}}
        <div class="flex-grow">
            <div class="flex justify-between items-start">
                <h3 class="todo-title text-xl font-bold text-gray-800 {{ $todo->is_complete ? 'line-through' : '' }}">{{ $todo->title }}</h3>
                
                <div class="todo-details text-right text-sm text-gray-500 ml-4 {{ $todo->is_complete ? 'line-through' : '' }}">
                    <p class="todo-time">{{ $todo->time }}</p>
                    <p class="todo-date">{{ \Carbon\Carbon::parse($todo->date)->format('d M Y') }}</p>
                </div>
            </div>
            
            <hr class="my-2">
            
            <p class="todo-bio text-gray-600 mt-2 {{ $todo->is_complete ? 'line-through' : '' }}">
                {{ $todo->bio }}
            </p>
            
            {{-- Tombol Aksi (Edit & Hapus) --}}
            <div class="mt-4 flex justify-end space-x-4">
                <button type="button" data-modal-toggle="edit-modal-{{ $todo->id }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Edit
                </button>
                <form method="POST" action="{{ route('todos.destroy', $todo->id) }}" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL EDIT (Tersembunyi secara default) --}}
    <div id="edit-modal-{{ $todo->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Konten Modal -->
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="edit-modal-{{ $todo->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Edit Tugas</h3>
                    <form class="space-y-6 edit-form" action="{{ route('todos.update', $todo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                            <input type="text" name="title" value="{{ $todo->title }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" name="date" value="{{ $todo->date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="time" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                                <input type="time" name="time" value="{{ $todo->time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                        </div>
                        <div>
                            <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea name="bio" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ $todo->bio }}</textarea>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
