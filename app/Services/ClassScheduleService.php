<?php

namespace App\Services;

use App\Repositories\Contracts\ClassScheduleRepositoryInterface;

class ClassScheduleService
{
    protected ClassScheduleRepositoryInterface $classScheduleRepository;

    public function __construct(ClassScheduleRepositoryInterface $classScheduleRepository)
    {
        $this->classScheduleRepository = $classScheduleRepository;
    }

    public function getAllSchedules()
    {
        return $this->classScheduleRepository->all();
    }

    public function getSchedulesByClassId($classId)
    {
        return $this->classScheduleRepository->getByClassId($classId);
    }

    public function createSchedule(array $data)
    {
        $classId = $data['classes_id'];

        $this->classScheduleRepository->deleteByClassId($classId);

        foreach ($data['schedule'] as $item) {
            $this->classScheduleRepository->create([
                'classes_id' => $classId,
                'date' => $item['date'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'location' => $item['location'] ?? null,
                'recurring_pattern' => $item['recurring_pattern'] ?? null,
            ]);
        }

        return true;
    }
}
