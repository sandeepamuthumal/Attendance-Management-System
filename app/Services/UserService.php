<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserService
{
    protected $userRepository;
    protected $teacherRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function getUsersByType(int $userTypeId)
    {
        try {
            $users = $this->userRepository->getAllByUserType($userTypeId);

            return $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'type' => $user->userType->user_type,
                    'name' => $user->full_name,
                    'email' => $user->email,
                    'contact' => $user->teacher ? $user->teacher->contact_no : 'N/A',
                    'subject' => $user->teacher && $user->teacher->subject ? $user->teacher->subject->subject : 'N/A',
                    'status' => $this->generateStatusBadge($user->status()),
                    'created_date' => $user->created_at->format('Y-m-d'),
                    'action' => $this->generateActionButtons($user->id, $user->status())
                ];
            });
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            throw new Exception('Failed to fetch users');
        }
    }

    public function createUser(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->create([
                'user_types_id' => $data['user_types_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => 1
            ]);

            // If creating a teacher, create teacher record
            if ($data['user_types_id'] == 2 && isset($data['teacher_data'])) {
                $this->teacherRepository->create([
                    'users_id' => $user->id,
                    'subjects_id' => $data['teacher_data']['subjects_id'],
                    'contact_no' => $data['teacher_data']['contact_no'],
                    'address' => $data['teacher_data']['address'],
                    'nic' => $data['teacher_data']['nic']
                ]);
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            throw new Exception('Failed to create user');
        }
    }

    public function updateUser(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $this->userRepository->update($id, [
                'user_types_id' => $data['user_types_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email']
            ]);

            // Update teacher data if user is a teacher
            if ($data['user_types_id'] == 2 && isset($data['teacher_data'])) {
                $teacher = $this->teacherRepository->findByUserId($id);

                if ($teacher) {
                    $this->teacherRepository->update($id, $data['teacher_data']);
                } else {
                    $this->teacherRepository->create([
                        'users_id' => $id,
                        ...$data['teacher_data']
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating user: ' . $e->getMessage());
            throw new Exception('Failed to update user');
        }
    }

    public function getUserForEdit(int $id)
    {
        try {
            return $this->userRepository->getUserWithRelations($id);
        } catch (Exception $e) {
            Log::error('Error fetching user for edit: ' . $e->getMessage());
            throw new Exception('Failed to fetch user data');
        }
    }

    public function deactivateUser(int $id)
    {
        try {
            return $this->userRepository->changeStatus($id, 0);
        } catch (Exception $e) {
            Log::error('Error deactivating user: ' . $e->getMessage());
            throw new Exception('Failed to deactivate user');
        }
    }

    public function activateUser(int $id)
    {
        try {
            return $this->userRepository->changeStatus($id, 1);
        } catch (Exception $e) {
            Log::error('Error activating user: ' . $e->getMessage());
            throw new Exception('Failed to activate user');
        }
    }

    public function resetUserPassword(int $id, string $password)
    {
        try {
            return $this->userRepository->resetPassword($id, $password);
        } catch (Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            throw new Exception('Failed to reset password');
        }
    }

    private function generateActionButtons(int $userId, string $status): string
    {
        $editBtn = '<button class="btn btn-xs btn-primary me-1 edit-user" data-id="' . $userId . '" title="Edit">
                        <i class="icon-pencil-alt"></i>
                    </button>';

        $resetBtn = '<button class="btn btn-xs btn-warning me-1 reset-password" data-id="' . $userId . '" title="Reset Password">
                         <i class="fa-solid fa-key"></i>
                     </button>';

        if ($status === 'active') {
            $statusBtn = '<button class="btn btn-xs btn-danger deactivate-user" data-id="' . $userId . '" title="Deactivate">
                              <i class="icon-trash"></i>
                          </button>';
        } else {
            $statusBtn = '<button class="btn btn-xs btn-success activate-user" data-id="' . $userId . '" title="Activate">
                              <i class="fa-solid fa-repeat"></i>
                          </button>';
        }

        return $editBtn . $resetBtn . $statusBtn;
    }

    private function generateStatusBadge(string $status): string
    {
        $badgeClass = $status === 'active' ? 'badge-success' : 'badge-danger';
        return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
    }
}
