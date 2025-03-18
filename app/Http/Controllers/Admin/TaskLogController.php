<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TaskLog;
use App\Models\Task;

class TaskLogController extends Controller
{
    public function index()
    {
        $taskLogs = TaskLog::with('task')->get();
        return view('admin.tasklogs.index', compact('taskLogs'));
    }

    public function create()
    {
        $tasks = Task::all(); // Ambil semua task untuk dropdown
        return view('admin.tasklogs.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_tasks,id',
            'status' => 'required|in:todo,in_progress,done',
            'description' => 'nullable|string',
            'changed_at' => 'required|date',
        ]);

        TaskLog::create([
            'task_id' => $request->task_id,
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => $request->changed_at,
        ]);

        return redirect()->route('admin.tasklogs.index')->with('success', 'Task log berhasil ditambahkan!');
    }

    public function show($id)
    {
        $taskLog = TaskLog::with('task')->findOrFail($id);
        return view('admin.tasklogs.show', compact('taskLog'));
    }

    public function edit($id)
    {
        $taskLog = TaskLog::findOrFail($id);
        $tasks = Task::all();
        return view('admin.tasklogs.edit', compact('taskLog', 'tasks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_tasks,id',
            'status' => 'required|in:todo,in_progress,done',
            'description' => 'nullable|string',
            'changed_at' => 'required|date',
        ]);

        $taskLog = TaskLog::findOrFail($id);
        $taskLog->update([
            'task_id' => $request->task_id,
            'status' => $request->status,
            'description' => $request->description,
            'changed_at' => $request->changed_at,
        ]);

        return redirect()->route('admin.tasklogs.index')->with('success', 'Task log berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $taskLog = TaskLog::findOrFail($id);
        $taskLog->delete();

        return redirect()->route('admin.tasklogs.index')->with('success', 'Task log berhasil dihapus!');
    }
}
