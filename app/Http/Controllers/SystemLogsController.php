<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class SystemLogsController extends Controller
{
    public function index()
    {
        // latest logs first
        $logs = ActivityLog::with('user')
            ->orderBy('created_at','desc')
            ->paginate(20);

        // SECURITY ALERTS
        $failedLogins = ActivityLog::where('action','LIKE','%failed%')->count();
        $intruderAttempts = ActivityLog::where('action','LIKE','%intruder%')->count();

        return view('admin.logs.index', compact(
            'logs',
            'failedLogins',
            'intruderAttempts'
        ));
    }
}