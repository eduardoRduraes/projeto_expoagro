<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use App\Rules\CpfValidation;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    public function index(Request $request)
    {
        $query = Operador::query();

        // Filtro por busca (nome ou CPF)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%')
                  ->orWhere('cpf', 'like', '%' . $search . '%');
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por categoria CNH
        if ($request->filled('categoria_cnh')) {
            $query->where('categoria_cnh', $request->categoria_cnh);
        }

        $operadores = $query->paginate(10);
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
            'cpf' => ['required', 'string', 'max:14', 'unique:operadores', new CpfValidation()],
            'telefone' => 'nullable|string|max:20',
            'status' => 'required|in:livre,em_servico',
            'categoria_cnh' => 'required|string|max:5',
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
            'cpf' => ['required', 'string', 'max:14', 'unique:operadores,cpf,' . $operador->id, new CpfValidation()],
            'telefone' => 'nullable|string|max:20',
            'status' => 'required|in:livre,em_servico',
            'categoria_cnh' => 'required|string|max:5',
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
