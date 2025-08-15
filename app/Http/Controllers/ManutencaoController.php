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
        $manutencoes = Manutencao::with(['maquina'])->paginate(10);
        return view('manutencoes.index',  compact('manutencoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maquinas = Maquina::where('status','=','livre')->get();
        $manutencao = null;
        return view('manutencoes.create',compact('maquinas', 'manutencao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'maquina_id' => 'required|exists:maquinas,id',
            'tipo' => 'required|in:preventiva,corretiva',
            'custo' => 'numeric|required|min:0',
            'descricao' => 'required|string|max:500',
            'data_manutencao' => 'nullable|date',
            'responsavel' => 'required|string|max:255',
        ]);

        Manutencao::create([
            'maquina_id' => $request->maquina_id,
            'tipo' => $request->tipo,
            'custo' => $request->custo,
            'descricao' => $request->descricao,
            'data_manutencao' => $request->data_manutencao,
            'responsavel' => $request->responsavel,
            'status' => 'manutencao',
        ]);

        $maquina = Maquina::find($request->maquina_id);

        if ($maquina ) {
            $maquina->update(['status' => 'manutencao']);
        }

        return redirect()->route('manutencoes.index')->with('success', 'Manutenção cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manutencao $manutencao)
    {
        return view('manutencoes.show', compact('manutencao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manutencao $manutencao)
    {
        $maquinas = Maquina::all();

        return view('manutencoes.edit', compact('manutencao', 'maquinas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manutencao $manutencao)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'tipo' => 'required|in:preventiva,corretiva',
            'status' => 'required|in:livre,manutencao',
            'custo' => 'required|numeric|min:0',
            'data_manutencao' => 'required|date',
            'responsavel' => 'required|string|max:255',
            'maquina_id' => 'required|exists:maquinas,id',
        ]);

        $manutencao->update($request->all());
        return redirect()->route('manutencoes.index')->with('success', 'Manutenção atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manutencao $manutencao)
    {
        $manutencao->delete();
        return redirect()->route('manutencoes.index')->with('success', 'Manutenção deletada com sucesso!');
    }
}
