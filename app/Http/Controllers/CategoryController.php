<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $saved = Category::create($data);
        return $this->sendResponse($saved, 'Category created successfully');
    }
}
