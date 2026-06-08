<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::with(['user', 'kategori'])->latest('tanggal')->paginate(10);
        return view('activity_logs.index', compact('activityLogs'));
    }
}
