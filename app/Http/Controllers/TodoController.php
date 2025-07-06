<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

/**
 * Controller ini menangani semua logika untuk To-Do List,
 * termasuk menampilkan, membuat, memperbarui, dan menghapus tugas.
 */
class TodoController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar tugas
     * milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil hanya todo milik pengguna yang sedang login, diurutkan dari yang terbaru.
        $todos = Todo::where('user_id', auth()->id())->latest()->get();
        
        // Kirim data 'todos' ke view 'dashboard' (karena kontennya ada di sana).
        return view('todos.index', ['todos' => $todos]);
    }

    /**
     * Menyimpan tugas baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dari form.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'bio' => 'nullable|string',
        ]);

        // Tambahkan ID pengguna yang sedang login ke data yang akan disimpan.
        $validated['user_id'] = auth()->id();
        
        // Beri nilai default 'false' untuk tugas baru.
        $validated['is_complete'] = false;

        // Buat entri baru di database menggunakan data yang sudah lengkap.
        Todo::create($validated);

        // Arahkan kembali pengguna ke halaman utama ('/') dengan pesan sukses.
        return redirect('/')->with('status', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Mengubah status selesai/belum selesai pada tugas (digunakan oleh AJAX).
     */
    public function toggleComplete(Todo $todo): JsonResponse
    {
        // Keamanan: Pastikan pengguna hanya bisa mengubah tugas miliknya.
        if ($todo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Balikkan nilai is_complete (true -> false, false -> true).
        $todo->is_complete = !$todo->is_complete;
        $todo->save();

        // Kirim respons JSON kembali ke JavaScript.
        return response()->json(['success' => true, 'is_complete' => $todo->is_complete]);
    }

    /**
     * Memperbarui data tugas yang sudah ada.
     */
    public function update(Request $request, Todo $todo): RedirectResponse
    {
        // Keamanan: Pastikan pengguna hanya bisa mengedit tugas miliknya.
        if ($todo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input dari form edit.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i,H:i:s',
            'bio' => 'nullable|string',
        ]);
        
        // Perbarui data di database.
        $todo->update($validated);
        
        // Arahkan kembali pengguna ke halaman utama ('/') dengan pesan sukses.
        return redirect('/')->with('status', 'Tugas berhasil diperbarui!');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        // Keamanan: Pastikan pengguna hanya bisa menghapus tugas miliknya.
        if ($todo->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus data dari database.
        $todo->delete();

        // Arahkan kembali pengguna ke halaman sebelumnya dengan pesan sukses.
        return back()->with('status', 'Tugas berhasil dihapus!');
    }
}
