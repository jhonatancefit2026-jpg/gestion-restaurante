<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menuItems')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:categories,name']);
        Category::create($request->only('name'));
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Category $categoria)
    {
        return view('admin.categories.edit', compact('categoria'));
    }

    public function update(Request $request, Category $categoria)
    {
        $request->validate(['name' => 'required|string|max:100|unique:categories,name,' . $categoria->id]);
        $categoria->update($request->only('name'));
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $categoria)
    {
        if ($categoria->menuItems()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría con items asociados.');
        }
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada.');
    }
}
