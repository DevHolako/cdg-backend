<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acte;
use Illuminate\Http\Request;

class ActeController extends Controller
{
    public function index()
    {
        $actes = Acte::all();
        return response()->json($actes);
    }

    public function show(string $id)
    {

        $acte = Acte::find($id);
        if (!$acte) {
            return response()->json(['message' => 'Acte not found'], 204);
        }

        return response()->json($acte);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'acte' => 'required|string',
            'montant' => 'required|numeric',
            'method' => 'required|string',
            'doc_id' => 'required|exists:docs,id',
            'date' => 'date',
        ]);
        $acte = Acte::create($data);
        return response()->json("Acte cretared successfully", 201);
    }

    public function update(Request $request, string $id)
    {
        $acte = Acte::find($id);

        if (!$acte) {
            return response()->json(['message' => 'Acte not found'], 204);
        }

        $fileds = $request->validate([
            'nom' => "sometimes|string",
            'prenom' => "sometimes|string",
            'acte' => "sometimes|string",
            'montant' => "sometimes|numeric",
            'method' => "sometimes|string",
            'doc_id' => "sometimes|exists:docs,id",
            'date' => 'sometimes|date',
        ]);
        $acte->update($fileds);
        return response()->json(['message' => 'acte updated successfully', "acte" => $acte], 200);
    }

    public function destroy(string $id)
    {
        $acte = Acte::find($id);

        if (!$acte) {
            return response()->json(['message' => 'User not found'], 204);
        }
        $acte->delete();
        return response()->json(['message' => 'Acte deleted successfully'], 201);
    }
}
