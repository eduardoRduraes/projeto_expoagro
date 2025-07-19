<?php

namespace App\Http\Controllers;

use App\Models\Manutencao;
use App\Models\Maquina;
use Illuminate\Http\Request;

class ManutencaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manutencoes = Manutencao::with(['maquina'])->get();
        return view('manutencoes.index',  compact('manutencoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maquinas = Maquina::where('status','=','livre')->get();
        return view('manutencoes.create',compact('maquinas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'maquina_id' => 'required|exists:maquinas,id',
            'tipo' => 'required',
            'custo' => 'numeric|required',
            'descricao' => 'required|string|max:200',
        ]);

        Manutencao::created([
            'maquina_id' => $request->maquina_id,
            'tipo' => $request->tipo,
            'custo' => $request->custo,
            'descricao' => $request->descricao,
        ]);

        $maquina = Maquina::find($request->maquina_id);

        if ($maquina ) {
            $maquina->update(['status' => 'manutencao']);
        }

        redirect()->route('manutencoes.index')->with('sucess');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manutencao $manutencoes)
    {
        return view('manutencoes.show', compact('manutencoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manutencao $manutencoes)
    {
        $maquinas = Maquina::all();

        return view('manutencoes.edit', compact('manutencoes', 'maquinas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manutencao $manutencoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manutencao $manutencoes)
    {
        //
    }
}
