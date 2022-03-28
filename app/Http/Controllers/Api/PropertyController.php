<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('title')->get()->map(fn($property) => [
            'id' => $property->id,
            'user_id' => $property->user_id,
            'title' => $property->title,
            'description' => $property->description,
            'price' => $property->price,
            'address' => $property->address,
            'number' => $property->number
        ]);

        return response()->json(['success' => true, 'data' => $properties]);
    }

    public function getByUser()
    {
        $id = auth('sanctum')->user()->id;

        $properties = Property::query()
            ->where('user_id', $id)
            ->orderBy('title')
            ->get()
            ->map(fn($property) => [
                'id' => $property->id,
                'user_id' => $property->user_id,
                'title' => $property->title,
                'description' => $property->description,
                'price' => $property->price,
                'address' => $property->address,
                'number' => $property->number
            ]);

        return response()->json(['success' => true, 'data' => $properties]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'address' => 'required',
            'number' => 'required|numeric',
        ]);

        $data['user_id'] = auth('sanctum')->user()->id;

        $properties = Property::create($data);

        return response()->json(['success' => true, 'data' => $properties]);
    }


    public function show(int $id)
    {
        $property = Property::find($id);

        return response()->json(['success' => true, 'data' => $property]);
    }


    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'address' => 'nullable',
            'number' => 'nullable',
        ]);

        $user_id = auth('sanctum')->user()->id;

        $property = Property::query()
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        $property->update($data);

        return response()->json(['success' => true, 'data' => $property]);
    }

    public function destroy($id)
    {
        $user_id = auth('sanctum')->user()->id;

        $property = Property::query()
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        $property->delete();

        return response()->json(['success' => true, 'data' => null]);
    }
}
