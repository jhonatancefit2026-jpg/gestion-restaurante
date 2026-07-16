<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data'  => Cliente::all(),
            'total' => Cliente::count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre'   => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'unique:clientes'],
            'telefono' => ['nullable', 'string'],
            'ciudad'   => ['nullable', 'string'],
        ]);

        $cliente = Cliente::create($data);

        return response()->json($cliente, 201); // 201 = Created
    }

    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente): JsonResponse
    {
        $data = $request->validate([
            'nombre'   => ['sometimes', 'string', 'max:120'],
            'email'    => ['sometimes', 'email', 'unique:clientes,email,'.$cliente->id],
            'telefono' => ['nullable', 'string'],
            'ciudad'   => ['nullable', 'string'],
            'activo'   => ['sometimes', 'boolean'],
        ]);

        $cliente->update($data);

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente): JsonResponse
    {
        $cliente->delete();

        return response()->json([
            'message' => 'Cliente eliminado correctamente.',
        ]);
    }
}
