<?php

namespace App\Services;

use App\Repositories\Interfaces\ClassScheduleRepositoryInterface;

class ClassScheduleService
{
    protected ClassScheduleRepositoryInterface $classScheduleRepository;

    public function __construct(ClassScheduleRepositoryInterface $classScheduleRepository)
    {
        $this->classScheduleRepository = $classScheduleRepository;
    }

    // Business logic methods will go here later
}
