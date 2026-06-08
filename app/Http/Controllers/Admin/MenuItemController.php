<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->latest()->paginate(12);
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'available'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $data['available'] = $request->boolean('available', true);

        MenuItem::create($data);
        return redirect()->route('admin.menu-items.index')->with('success', 'Item creado exitosamente.');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'available'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($menuItem->image) Storage::disk('public')->delete($menuItem->image);
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $data['available'] = $request->boolean('available');
        $menuItem->update($data);
        return redirect()->route('admin.menu-items.index')->with('success', 'Item actualizado.');
    }

    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) Storage::disk('public')->delete($menuItem->image);
        $menuItem->delete();
        return redirect()->route('admin.menu-items.index')->with('success', 'Item eliminado.');
    }
}
