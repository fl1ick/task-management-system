<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'is_read' => 'boolean',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'is_read' => $request->is_read ?? false,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'is_read' => 'boolean',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'is_read' => $request->is_read ?? false,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil dihapus!');
    }
}
