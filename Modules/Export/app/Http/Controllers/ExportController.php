<?php

namespace Modules\Export\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Export\Jobs\ExportNotesJob;

class ExportController extends Controller
{
    public function export()
    {
        $user = Auth::user();
        $filename = "exports/notes_{$user->id}_" . now()->timestamp . '.xlsx';

        ExportNotesJob::dispatch($user->id, $filename);

        return back()->with('success', 'Экспорт запущен. Файл скоро будет доступен для скачивания.')
                     ->with('export_filename', basename($filename));
    }

    public function download(string $filename)
    {
        $path = "exports/{$filename}";

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'Файл ещё не готов. Попробуйте через несколько секунд.');
        }

        return Storage::disk('local')->download($path);
    }

    // API methods

    public function store()
    {
        $user = Auth::user();
        $filename = "exports/notes_{$user->id}_" . now()->timestamp . '.xlsx';

        ExportNotesJob::dispatch($user->id, $filename);

        return response()->json([
            'message' => 'Экспорт запущен. Файл будет доступен для скачивания.',
            'filename' => basename($filename),
        ], 202);
    }

    public function show(string $filename)
    {
        $path = "exports/{$filename}";

        if (!Storage::disk('local')->exists($path)) {
            return response()->json([
                'message' => 'Файл ещё не готов или не найден.',
            ], 404);
        }

        return Storage::disk('local')->download($path);
    }
}
