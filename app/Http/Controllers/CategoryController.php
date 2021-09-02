<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $categories = Category::sortable()->simplePaginate(5);
        return view('category.index', compact('categories'));
    }

    public function create() {
        return view('category.create');
    }

    public function store(Request $request) {
        $this->validate($request, Category::$rules);
        $category = new Category([
            'name' => $request->input('name'),      // ユーザー入力を取得
        ]);
        if ($category->save()) {
            $request->session()->flash('success', __('カテゴリを新規登録しました'));
        } else {
            $request->session()->flash('error', __('カテゴリの新規登録に失敗しました'));
        }

        return redirect()->route('admin.category.index');
    }

    public function edit($id) {
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, Category::$rules);
        $category = Category::find($id);
        $category->name = $request->input('name');
        if ($category->save()) {
            $request->session()->flash('success', __('カテゴリを更新しました'));
        } else {
            $request->session()->flash('error', __('カテゴリの更新に失敗しました'));
        }

        return redirect()->route('admin.category.index');
    }

    public function destroy(Request $request, $id) {
        $category = Category::find($id);
        $event_category = Event::where('category_id', $category->id)->first();
        if ($event_category) {
            $request->session()->flash('error', __('このカテゴリは削除できません'));
        } else {
            $category->delete();
            $request->session()->flash('success', __('カテゴリを削除しました'));
        }
        
        return redirect()->route('admin.category.index');
    }
}
