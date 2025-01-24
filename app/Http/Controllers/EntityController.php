<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of entities.
     */
    public function index()
    {
        $entities = Entity::all(); // Retrieve all entities from the database
        return view('entities.index', compact('entities'));
    }

    /**
     * Show the form for creating a new entity.
     */
    public function create()
    {
        return view('entities.create');
    }

    /**
     * Store a newly created entity in the database.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the entity
        Entity::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('entities.index')->with('success', 'Entity created successfully!');
    }

    /**
     * Show the form for editing the specified entity.
     */
    public function edit(Entity $entity)
    {
        return view('entities.edit', compact('entity'));
    }

    /**
     * Update the specified entity in the database.
     */
    public function update(Request $request, Entity $entity)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the entity details
        $entity->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('entities.index')->with('success', 'Entity updated successfully!');
    }

    /**
     * Remove the specified entity from the database.
     */
    public function destroy(Entity $entity)
    {
        $entity->delete(); // Delete the entity
        return redirect()->route('entities.index')->with('success', 'Entity deleted successfully!');
    }
}
