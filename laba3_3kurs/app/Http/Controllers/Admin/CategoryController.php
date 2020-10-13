<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('admin.categories.index', [
            'categories' => Category::paginate(10)
        ]);
    }
    public function create() {
        return view('admin.categories.create', [
            'category' => [],
            'categories' => Category::with('children')->where('parent_id','0')->get(),
            'delimiter' => ''
        ]);
    }
    public function store(Request $request) {
        Category::create($request->all());

        return redirect()->route('admin.category.index');
    }
    public function edit(Category $category) {
        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::with('children')->where('parent_id','0')->get(),
            'delimiter' => ''
        ]);
    }
    public function update(Request $request, Category $category) {
        $category->update($request->all());
        
        return redirect()->route('admin.category.index');
    }
    public function show($id) {
        if($id == 0) {
            $categories = Category::orderBy('created_at')->get();
        }else if($id > 0){
            $categories = Category::orderBy('created_at')->where('parent_id', $id)->get();
        } else if($id == -1) {
            $categories = Category::orderBy('id')->get();
        } else {
            $categories = Category::orderBy('updated_at')->get();
        }

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }
}
