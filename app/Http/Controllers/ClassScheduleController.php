<?php

namespace App\Http\Controllers;

use App\Services\ClassScheduleService;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    protected $classScheduleService;

    public function __construct(ClassScheduleService $classScheduleService)
    {
        $this->classScheduleService = $classScheduleService;
    }
    public function loadSchedule(Request $request)
    {
        $data = $this->classScheduleService->getSchedulesByClassId($request->class_id);

        return response()->json([
            'schedule' => $data
        ]);
    }

    public function saveSchedule(Request $request)
    {
        try {
            $data['classes_id'] = $request->id;
            $data['schedule'] = $request->schedule;
            $this->classScheduleService->createSchedule($data);

            return response()->json([
                'message' => 'Schedule saved'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Failed to save schedule: ' . $th->getMessage()
            ], 500);
        }
    }
}
