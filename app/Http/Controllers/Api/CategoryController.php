<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       	$pagination = 10;
        $posts = Category::paginate($pagination); //all();

        return sendResponse(CategoryResource::collection($posts), 'Categories retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:5'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

        try {
            $post    = Category::create([
                'name'       => $request->name,
                'user_id'    => $request->user_id
            ]);
            $success = new CategoryResource($post);
            $message = 'Yay! A post has been successfully created.';
        } catch (Exception $e) {
            $success = [];
            $message = 'Oops! Unable to create a new post.';
        }

        return sendResponse($success, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Category::find($id);

        if (is_null($post)) return sendError('Category not found.');

        return sendResponse(new CategoryResource($post), 'Category retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category    $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $post)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|min:5'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

        try {
            $post->name     = $request->name;
            $post->user_id 	= $request->user_id;
            $post->save();

            $success = new CategoryResource($post);
            $message = 'Yay! Category has been successfully updated.';
        } catch (Exception $e) {
            $success = [];
            $message = 'Oops, Failed to update the post.';
        }

        return sendResponse($success, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $post)
    {
        try {
            $post->delete();
            return sendResponse([], 'The Category has been successfully deleted.');
        } catch (Exception $e) {
            return sendError('Oops! Unable to delete post.');
        }
    }
}
