<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return (new CategoryCollection($categories))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $validated = $request->validated();
            $category = Category::create($validated);
            return (new CategoryResource($category))
                ->response()
                ->setStatusCode(201);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $category = Category::findOrFail($id);
                return (new CategoryResource($category))
                    ->response()
                    ->setStatusCode(200);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $category = Category::findOrFail($id);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
            $validated = $request->validated();
            $category->update($validated);
            return (new CategoryResource($category))
                ->response()
                ->setStatusCode(200);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $category = Category::findOrFail($id);
                $category->delete();
                return response()->json([], 204);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
