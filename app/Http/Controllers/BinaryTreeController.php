<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinaryTreeNode;
use Illuminate\Support\Facades\DB;

class BinaryTreeController extends Controller
{
    public function history() {
        $history = BinaryTreeNode::all();
        return response()->json([
            'status' => 'success',
            'history' => $history
        ], 200);
    }
    public function saveTree(Request $request)
    {
        $validatedData = $request->validate([
            'treeData' => 'required|array',
            'treeData.*.level' => 'required|integer',
            'treeData.*.value' => 'required|integer',
        ]);

        foreach ($validatedData['treeData'] as $node) {
            BinaryTreeNode::create([
                'level' => $node['level'],
                'value' => $node['value'],
            ]);
        }

        return response()->json(['message' => 'Binary tree saved successfully']);
    }
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
