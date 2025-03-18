<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;

class BoardsController extends Controller
{
    public function index()
    {
        $boards = Boards::all();
        return view('welcome', compact('boards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Boards::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Board berhasil dibuat!');
    }


    public function show($id)
    {
        $boards = Boards::findOrFail($id);
        return view('boards.show', compact('boards'));
    }

    public function edit($id)
    {
        $boards = Boards::findOrFail($id);
        return view('boards.edit', compact('boards'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $boards = Boards::findOrFail($id);
        $boards->update([
            'name' => $request->name,
        ]);

        return redirect()->route('boards.index')->with('success', 'Board berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $boards = Boards::findOrFail($id);
        $boards->delete();

        return redirect()->route('boards.index')->with('success', 'Board berhasil dihapus!');
    }
}
