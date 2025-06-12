<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->orderBy('created_at', 'desc');

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->input('desde'));
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->input('hasta'));
        }

        $logs = $query->paginate(10);

        foreach ($logs as $log) {
            $log->translated_description = match ($log->description) {
                'created' => 'Agregado',
                'updated' => 'Editado',
                'deleted' => 'Eliminado',
                default => ucfirst($log->description),
            };
        }

        $groupedLogs = $logs->groupBy('translated_description');

        return view('activity.index', compact('logs', 'groupedLogs'));
    }
}
