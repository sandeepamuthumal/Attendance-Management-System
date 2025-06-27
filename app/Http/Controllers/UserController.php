<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\UserType;
use App\Models\Subject;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function admins()
    {
        $userTypes = UserType::all();
        return view('pages.admin.users.admins', compact('userTypes'));
    }

    public function teachers()
    {
        $userTypes = UserType::all();
        $subjects = Subject::all();
        return view('pages.admin.users.teachers', compact('userTypes', 'subjects'));
    }

    public function loadUsers(Request $request): JsonResponse
    {
        try {
            $userTypeId = $request->get('user_types_id', 1); // Default to admin
            $users = $this->userService->getUsersByType($userTypeId);

            return response()->json($users);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Prepare teacher data if user type is teacher
            if ($data['user_types_id'] == 2) {
                $data['teacher_data'] = [
                    'subjects_id' => $data['subjects_id'],
                    'contact_no' => $data['contact_no'],
                    'address' => $data['address'],
                    'nic' => $data['nic']
                ];
            }

            $this->userService->createUser($data);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->getUserForEdit($request->id);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $response = [
                'user' => $user,
            ];

            if ($user->teacher) {
                $response['teacher'] = $user->teacher;
            }

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Prepare teacher data if user type is teacher
            if ($data['user_types_id'] == 2) {
                $data['teacher_data'] = [
                    'subjects_id' => $data['subjects_id'],
                    'contact_no' => $data['contact_no'],
                    'address' => $data['address'],
                    'nic' => $data['nic']
                ];
            }

            $this->userService->updateUser($request->user_id, $data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deactivate(Request $request, int $id): JsonResponse
    {
        try {
            $this->userService->deactivateUser($id);

            return response()->json([
                'success' => true,
                'message' => 'User deactivated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function activate(Request $request, int $id): JsonResponse
    {
        try {
            $this->userService->activateUser($id);

            return response()->json([
                'success' => true,
                'message' => 'User activated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $this->userService->resetUserPassword($data['user_id'], $data['password']);

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
