<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ImportNotesFromApiJob;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Auth::user()->notes()->OrderBy('date', 'desc')->get();

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'note_date' => 'required|date|after_or_equal:1900-01-01|before_or_equal:2100-12-31'
        ]);

        Auth::user()->notes()->create($validated);

        return redirect()->route('notes.index')->with('success', 'Заметка создана успешно!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен!');
        }

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен!');
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен!');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'note_date' => 'required|date|after_or_equal:1900-01-01|before_or_equal:2100-12-31'
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Заметка успещно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен!');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Заметка успешно удалена!');
    }

    /**
     * Show the import form.
     */
    public function import()
    {
        return view('notes.import');
    }

    /**
     * Handle the import request.
     */
    public function processImport(Request $request)
    {
        $validated = $request->validate([
            'api_url' => 'required|url',
        ], [
            'api_url.required' => 'URL API обязателен для заполнения',
            'api_url.url' => 'Введите корректный URL',
        ]);

        // Отправить задачу в очередь
        ImportNotesFromApiJob::dispatch(Auth::id(), $validated['api_url']);

        return redirect()->route('notes.index')
            ->with('success', 'Импорт запущен! Заметки появятся через несколько секунд.');
    }
}
