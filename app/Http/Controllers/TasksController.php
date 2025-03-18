<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Boards;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    // Menampilkan halaman index dengan task user yang login
    public function index()
    {
        $boards = Boards::first();
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.index', compact('tasks','boards'));
    }

    // Menyimpan task baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'status'      => 'required|in:todo,in_progress,done',
            'board_id'    => 'required|exists:tbl_boards,id',
        ]);

        Task::create([
            'board_id'    => $request->board_id,
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status'      => $request->status,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil ditambahkan!');
    }

    // Update status task (drag & drop)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task = Task::findOrFail($id);
        $task->update(['status' => $request->status]);

        return redirect()->route('tasks.index')->with('success', 'Status task berhasil diperbarui!');
    }

    public function show($id)
    {
        $task = Task::with('board')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $boards = Board::all();
        return view('tasks.edit', compact('task', 'boards'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task berhasil dihapus!');
    }
}
