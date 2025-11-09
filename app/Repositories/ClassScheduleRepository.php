<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassSchedule;
use App\Repositories\Interfaces\ClassScheduleRepositoryInterface;

class ClassScheduleRepository implements ClassScheduleRepositoryInterface
{
    public function all()
    {
        return ClassSchedule::all();
    }

    public function find($id)
    {
        return ClassSchedule::findOrFail($id);
    }

    public function create(array $data)
    {
        return ClassSchedule::create($data);
    }

    public function update($id, array $data)
    {
        $schedule = $this->find($id);
        $schedule->update($data);
        return $schedule;
    }

    public function delete($id)
    {
        $schedule = $this->find($id);
        return $schedule->delete();
    }
}
