<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doc;

class DocController extends Controller

{



    public function __construct()
    {
        $this->middleware(["ability:view,full"])->only('index', 'show');
        $this->middleware(["ability:full"])->only("store", "update", "destory");
    }


    public function index()
    {
        $docs = Doc::all();
        return response()->json($docs);
    }

    public function show(string $id)
    {
        $doc = Doc::find($id);

        if (!$doc) {
            return response()->json(['message' => 'Doc not found'], 404);
        }

        return response()->json($doc);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomComplete' => 'required|string',
        ]);

        $doc = Doc::create($data);

        return response()->json(['message' => 'Doc created successfully', 'doc' => $doc], 201);
    }

    public function update(Request $request, string $id)
    {
        $doc = Doc::find($id);

        if (!$doc) {
            return response()->json(['message' => 'Doc not found'], 404);
        }

        $fields = $request->validate([
            'nomComplete' => 'required|string',
        ]);

        $doc->update($fields);

        return response()->json(['message' => 'Doc updated successfully', 'doc' => $doc], 200);
    }

    public function destroy(string $id)
    {
        $doc = Doc::find($id);

        if (!$doc) {
            return response()->json(['message' => 'Doc not found'], 404);
        }

        $doc->delete();

        return response()->json(['message' => 'Doc deleted successfully'], 200);
    }
}
