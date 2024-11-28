<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Categoria;
use App\Models\PagoMetodo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%'])
            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($query) . '%'])
            ->get();

        $pizzas = Pizza::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($query) . '%'])
            ->get();

        $categorias = Categoria::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($query) . '%'])
            ->get();

        $metodosPago = PagoMetodo::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($query) . '%'])
            ->get();

        return inertia('Search/Results', [
            'query' => $query,
            'users' => $users,
            'pizzas' => $pizzas,
            'categorias' => $categorias,
            'metodosPago' => $metodosPago,
        ]);
    }

}
