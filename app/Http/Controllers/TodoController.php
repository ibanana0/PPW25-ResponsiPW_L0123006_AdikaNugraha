<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{
    public function index()
    // route --> /todos/
    {
        $todos = Todo::orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get();
        return view('todos.index', ["todos" => $todos]);    // me-return todos.index dan $todos
    }
	
	public function update(Request $request, Todo $todo): JsonResponse
	{
		$validated = $request->validate([
			'title' => 'required|string|max:255',
			'date' => 'required|date',
			'time' => 'required|date_format:H:i',
			'bio' => 'nullable|string',
		]);
		
		$todo->update($validated);
		
		// Kirim kembali data yang sudah diformat untuk ditampilkan
		return response()->json([
			'success' => true,
			'todo' => [
				'title' => $todo->title,
				'time' => $todo->time,
				'date_formatted' => \Carbon\Carbon::parse($todo->date)->format('d M Y'),
				'bio' => $todo->bio,
			]
		]);
	}
	
	public function destroy(Todo $todo): RedirectResponse
	{
		$todo->delete();
		
		return back()->with('status', 'Tugas berhasil dihapus!');
	}
	
	public function toggleComplete(Todo $todo): JsonResponse
	{
		$todo->is_complete = !$todo->is_complete;
		$todo->save();
		
		return response()->json([
			'success' => true,
			'is_complete' => $todo->is_complete,
			'message' => 'Status tugas berhasil diperbarui!'
		]);
	}
	
	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'title' => 'required|string|max:255',
			'date' => 'required|date',
			'time' => 'required|date_format:H:i',
			'bio' => 'nullable|string',
		]);
		
		$validated['is_complete'] = false;
		
		Todo::create($validated);
		
		return redirect('/')->with('status', 'Tugas baru berhasil ditambahkan!');
	}
}
