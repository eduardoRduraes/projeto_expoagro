<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    public function index()
    {
        $operadores = Operador::all();
        return view('operadores.index', compact('operadores'));
    }

    public function create()
    {
        return view('operadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14|unique:operadores',
            'telefone' => 'nullable|string|max:20',
            'status' => 'required',
            'categoria_cnh' => 'required',
        ]);

        Operador::create($request->all());
        return redirect()->route('operadores.index')->with('success', 'Operador cadastrado com sucesso!');
    }

    public function show(Operador $operador)
    {
        return view('operadores.show', compact('operador'));
    }

    public function edit(Operador $operador)
    {
        return view('operadores.edit', compact('operador'));
    }

    public function update(Request $request, Operador $operador)
    {
        $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14|unique:operadores, cpf,' . $operador->id,
            'telefone' => 'nullable|string|max:20',
            'categoria_cnh' => 'required' ,
        ]);

        $operador->update($request->all());
        return redirect()->route('operadores.index')->with('success', 'Operador editado com sucesso!');
    }

    public function destroy(Operador $operador)
    {
        $operador->delete();
        return redirect()->route('operadores.index')->with('success', 'Operador deletado com sucesso!');
    }
}
