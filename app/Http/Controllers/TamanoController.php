<?php
namespace App\Http\Controllers;

use App\Models\Tamano;
use Illuminate\Http\Request;

class TamanoController extends Controller
{
    public function index()
    {
        $tamanos = Tamano::all();
        return inertia('Tamanos/Index', ['tamanos' => $tamanos]);
    }

    public function create()
    {
        return inertia('Tamanos/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Tamano::create($request->all());

        return redirect()->route('tamanos.index')->with('success', 'Tamaño creado exitosamente.');
    }

    public function edit(Tamano $tamano)
    {
        return inertia('Tamanos/Edit', ['tamano' => $tamano]);
    }

    public function update(Request $request, Tamano $tamano)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tamano->update($request->all());

        return redirect()->route('tamanos.index')->with('success', 'Tamaño actualizado exitosamente.');
    }

    public function destroy(Tamano $tamano)
    {
        $tamano->delete();

        return redirect()->route('tamanos.index')->with('success', 'Tamaño eliminado exitosamente.');
    }
}
