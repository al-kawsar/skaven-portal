<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return Inertia::render('App/Schedule/Index', ['schedules' => $schedules]);
    }

    public function create()
    {
        return Inertia::render('App/Schedule/Create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data
        Schedule::create($request->all());
        return redirect()->route('app.schedules.index');
    }

    public function show(Schedule $schedule)
    {
        return Inertia::render('App/Schedule/Show', ['schedule' => $schedule]);
    }

    public function edit(Schedule $schedule)
    {
        return Inertia::render('App/Schedule/Edit', ['schedule' => $schedule]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update($request->all());
        return redirect()->route('app.schedules.index');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('app.schedules.index');
    }
}
