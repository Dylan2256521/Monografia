<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;


class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = Activity::with('causer')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $groupedLogs = $logs->groupBy('description'); // Agrupar por evento (created, updated, deleted)

    return view('activity.index', compact('groupedLogs', 'logs'));
    }
}
