<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{
    public function index()
    {
        $post = Category::select('id', 'name')
            ->withCount('posts as count')
            ->get();
        return $this->sendResponse($post, 'All categories');
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $saved = Category::create($data);
        return $this->sendResponse($saved, 'Category created successfully');
    }

    public function update(Category $category, CategoryStoreRequest $request)
    {
        $data = $request->validated();
        $category->update($data);

        return $this->sendResponse($category, 'Update successful');
    }

    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->posts()->each(function ($post) {
                $post->delete();
            });

            $category->delete();
        });

        return $this->sendResponse([], 'Deleted successfully');
    }
}
