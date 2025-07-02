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
        $maquinas = Maquina::all();
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
            'nome' => 'required',
            'modelo' => 'nullable',
            'numero_serie' => 'required|unique:maquinas',
            'tipo' => 'required',
            'ano' => 'required|digits:4|integer',
            'status' => 'required',
        ]);

        Maquina::create($request->all());
        return redirect()->route('maquinas.index')->with('success', 'Maquina cadastrada com sucesso!');
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
            'nome' => 'required',
            'numero_serie' => 'required|unique:maquinas, numero_serie,' . $maquina->id . ',id',
        ]);

        $maquina->update($request->all());
        return redirect()->route('maquinas.index')->with('success', 'Maquina atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maquina $maquina)
    {
        $maquina->delete();
        return redirect()->route('maquinas.index')->with('success', 'Maquina deletada com sucesso!');
    }
}
