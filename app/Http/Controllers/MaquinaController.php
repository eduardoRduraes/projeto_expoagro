<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinas = Maquina::paginate(10);
        return view('maquinas.index', compact('maquinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maquinas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:maquinas',
            'tipo' => 'required|in:emplemento,caminhao,carro,trator',
            'ano' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'status' => 'required|in:livre,em_servico,manutencao,inativo',
            'horas_totais' => 'nullable|numeric|min:0',
        ]);

        Maquina::create($request->all());
        return redirect()->route('maquinas.index')->with('success', 'Máquina cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maquina $maquina)
    {
        return  view('maquinas.show', compact('maquina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maquina $maquina)
    {
        return view('maquinas.edit', compact('maquina'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maquina $maquina)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:maquinas,numero_serie,' . $maquina->id,
            'tipo' => 'required|in:emplemento,caminhao,carro,trator',
            'ano' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'status' => 'required|in:livre,em_servico,manutencao,inativo',
            'horas_totais' => 'nullable|numeric|min:0',
        ]);

        $maquina->update($request->all());
        return redirect()->route('maquinas.index')->with('success', 'Máquina atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maquina $maquina)
    {
        $maquina->delete();
        return redirect()->route('maquinas.index')->with('success', 'Máquina deletada com sucesso!');
    }
}
