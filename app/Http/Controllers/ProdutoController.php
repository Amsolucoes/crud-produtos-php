<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
// GET /api/produtos - lista todos
    public function index()
    {
        return response()->json(Produto::all());
    }

    // POST /api/produtos - cria um novo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade_estoque' => 'nullable|integer|min:0',
        ]);

        $produto = Produto::create($validated);

        return response()->json($produto, 201);
    }

    // GET /api/produtos/{id} - mostra um específico
    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);

        return response()->json($produto);
    }

    // PUT/PATCH /api/produtos/{id} - atualiza
    public function update(Request $request, string $id)
    {
        $produto = Produto::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'sometimes|required|numeric|min:0',
            'quantidade_estoque' => 'nullable|integer|min:0',
        ]);

        $produto->update($validated);

        return response()->json($produto);
    }

    // DELETE /api/produtos/{id} - remove
    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return response()->json(null, 204);
    }
}
