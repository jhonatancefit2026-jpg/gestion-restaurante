<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::orderBy('number')->paginate(15);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number'   => 'required|integer|unique:tables,number',
            'capacity' => 'required|integer|min:1|max:20',
            'status'   => 'required|in:free,occupied,reserved',
        ]);
        RestaurantTable::create($request->only('number', 'capacity', 'status'));
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa creada.');
    }

    public function edit(RestaurantTable $mesa)
    {
        return view('admin.tables.edit', compact('mesa'));
    }

    public function update(Request $request, RestaurantTable $mesa)
    {
        $request->validate([
            'number'   => 'required|integer|unique:tables,number,' . $mesa->id,
            'capacity' => 'required|integer|min:1|max:20',
            'status'   => 'required|in:free,occupied,reserved',
        ]);
        $mesa->update($request->only('number', 'capacity', 'status'));
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa actualizada.');
    }

    public function destroy(RestaurantTable $mesa)
    {
        if ($mesa->orders()->whereIn('status', ['pending','preparing','ready'])->exists()) {
            return back()->with('error', 'No se puede eliminar una mesa con pedidos activos.');
        }
        $mesa->delete();
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa eliminada.');
    }
}
