<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BinaryTreeController extends Controller
{
   public function generateTree(Request $request)
    {
        $numbers = $request->input('numbers');

        if (!is_array($numbers) || empty($numbers)) {
            return response()->json(['error' => 'Invalid input. Provide an array of numbers.'], 422);
        }

        function insertNode($root, $value) {
            if ($root === null) {
                return ['value' => $value, 'left' => null, 'right' => null];
            }

            if ($value < $root['value']) {
                $root['left'] = insertNode($root['left'], $value);
            } else {
                $root['right'] = insertNode($root['right'], $value);
            }

            return $root;
        }

        $tree = null;
        foreach ($numbers as $number) {
            $tree = insertNode($tree, $number);
        }

        return response()->json($tree);
    }
}
