<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use Illuminate\Http\Request;

class UsoMaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usos = UsoMaquina::with(['maquina','operador'])->get();

        return view('usomaquinas.index', compact('usos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maquinas = Maquina::where('status','=','ativo')->get();
        $operadores = Operador::where('status','=','livre')->get();

        return view('usomaquinas.create', compact('maquinas','operadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'maquina_id' => 'required|exists:maquinas,id',
            'operador_id' => 'required|exists:operadores,id',
            'data' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'observacao' => 'nullable|string|max:200',
            'tarefa' => 'nullable|string|max:255',
        ]);

        $inicio = strtotime($request->hora_inicio);
        $fim = strtotime($request->hora_fim);
        $total_horas = round(($fim - $inicio) / 3600, 2);

        UsoMaquina::create([
            'maquina_id' => $request->maquina_id,
            'operador_id' => $request->operador_id,
            'data' => $request->data,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'total_horas' => $total_horas,
            'observacao' => $request->observacao,
            'tarefa' => $request->tarefa,
        ]);

        // Atualizar status da máquina
        $maquina = Maquina::find($request->maquina_id);

        $operador = Operador::find($request->operador_id);

        if ($maquina && $operador) {
            $maquina->update(['status' => 'em_servico']);
            $operador->update(['status' => 'em_servico']);
        }



        return redirect()->route('usomaquinas.index')->with('success', 'Uso de Máquina cadastrado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(UsoMaquina $usomaquina)
    {
        return view('usomaquinas.show', compact('usomaquina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UsoMaquina $usomaquina)
    {
        $maquinas = Maquina::all();
        $operadores = Operador::all();

        return view('usomaquinas.edit', compact('usomaquina','maquinas','operadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UsoMaquina $usosMaquinas)
    {
        $request->validate([
            'maquina_id' => 'required|exists:maquinas,id',
            'operador_id' => 'required|exists:operadores,id',
            'data' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'total_horas' => 'required|numeric',
            'tarefa' => 'nullable|string|max:255',
            'observacao' => 'nullable|string|max:200',
        ]);

        $inicio = strtotime($request->hora_inicio);
        $fim = strtotime($request->hora_fim);
        $total_horas = round(($fim - $inicio) / 3600, 2);

        $usosMaquinas->update([
            'maquina_id' => $request->maquina_id,
            'operador_id' => $request->operador_id,
            'data' => $request->data,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'total_horas' => $total_horas,
            'tarefa' => $request->tarefa,
            'observacao' => $request->observacao,
        ]);

        return redirect()->route('usomaquinas.index')->with('success', 'Uso Maquina Atualizada com Sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UsoMaquina $usomaquina)
    {
        $usomaquina->delete();
        return redirect()->route('usomaquinas.index')->with('success', 'Uso Maquina Deletada com Sucesso!');
    }
}
