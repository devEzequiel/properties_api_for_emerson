<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->user->find($id);

            return response()->json([
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);

            return response()->json([
                'data' => [
                    'status' => 'success',
                    'data' => $user
                ]], 202);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }


    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        if ($request->has('password') && $request->get('password')) {

            Validator::make($data, [
                'password' => 'required|confirmed'
            ])->validate();

            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $user = $this->user->find($id);
            $user->update($data);

            return response()->json(['data' => ['success' => true]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->user->find($id);
            $user->delete();

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }

    }
}
