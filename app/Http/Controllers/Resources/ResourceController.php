<?php

namespace App\Http\Controllers\Resources;

use App\Models\Resources\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class ResourceController extends \App\Http\Controllers\Controller
{
    /**
     * Get all the resources.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Resource::latest()->paginate(), 200
        );
    }

    /**
     * Get a single resource or return a UUID to create one.
     *
     * @param null $id
     * @return JsonResponse
     */
    public function show($id = null): JsonResponse
    {
        if (Resource::pluck('id')->contains($id) || $this->isNewResource($id)) {
            if ($this->isNewResource($id)) {
                return response()->json(Resource::make([
                    'id' => Uuid::uuid4(),
                ]), 200);
            } else {
                $resource = Resource::find($id);

                if ($resource) {
                    return response()->json($resource, 200);
                } else {
                    return response()->json(null, 301);
                }
            }
        }
    }

    /**
     * Create or update a resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function store(string $id): JsonResponse
    {
        $data = [
            'id' => request('id'),
            'title' => request('title'),
            'description' => request('description'),
            'path' => request('path'),
            'user_id' => request()->user()->id,
        ];

        $messages = [
            'required' => __('app.validation_required'),
            'unique' => __('app.validation_unique'),
        ];

        validator($data, [
            'name' => 'required',
            'title' => 'required|string|size:120',
            'description' => 'required|string|size:255',
            'path' => 'required|string|size:255',
            'user_id' => 'required|integer',
        ], $messages)->validate();

        $resource = $id !== 'create' ? Resource::find($id) : new Resource(['id' => request('id')]);

        $resource->fill($data);
        $resource->save();

        return response()->json($resource->refresh(), 201);
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        $resource = Resource::find($id);

        if ($resource) {
            $resource->delete();

            return response()->json([], 204);
        }
    }

    /**
     * Return true if we're creating a new resource.
     *
     * @param string $id
     * @return bool
     */
    private function isNewResource(string $id): bool
    {
        return $id === 'create';
    }
}
