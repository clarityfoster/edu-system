<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
<<<<<<< HEAD
=======
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
>>>>>>> af45e3d (add login and register ui)
    public function rolesForRegister() {
        $roles = Role::where('name', '!=', 'admin')->get();
        return response()->json([
            'roles' => $roles,
        ], 200);
    }
<<<<<<< HEAD
=======

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
>>>>>>> af45e3d (add login and register ui)
}
