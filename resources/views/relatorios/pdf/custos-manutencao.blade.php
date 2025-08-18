<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Custos de Manutenção</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2d5016;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2d5016;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #2d5016;
        }
        .stat-label {
            color: #666;
            font-size: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #2d5016;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2d5016;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .currency {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔧 Relatório de Custos de Manutenção</h1>
        <p>Período: {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataFim)) }}</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-value">{{ $totalManutencoes }}</div>
            <div class="stat-label">Total de Manutenções</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">R$ {{ number_format($custoTotal, 2, ',', '.') }}</div>
            <div class="stat-label">Custo Total</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">R$ {{ number_format($custoMedio, 2, ',', '.') }}</div>
            <div class="stat-label">Custo Médio</div>
        </div>
    </div>

    @if($custosPorTipo->count() > 0)
    <div class="section">
        <h2>📊 Custos por Tipo de Manutenção</h2>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Custo Total</th>
                    <th>Custo Médio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($custosPorTipo as $tipo)
                <tr>
                    <td>{{ $tipo['tipo'] }}</td>
                    <td>{{ $tipo['quantidade'] }}</td>
                    <td class="currency">R$ {{ number_format($tipo['total'], 2, ',', '.') }}</td>
                    <td class="currency">R$ {{ number_format($tipo['total'] / $tipo['quantidade'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($maquinasMaisCustosas->count() > 0)
    <div class="section">
        <h2>💰 Máquinas com Maiores Custos</h2>
        <table>
            <thead>
                <tr>
                    <th>Máquina</th>
                    <th>Quantidade de Manutenções</th>
                    <th>Custo Total</th>
                    <th>Custo Médio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maquinasMaisCustosas as $maquina)
                <tr>
                    <td>{{ $maquina['nome'] }}</td>
                    <td>{{ $maquina['quantidade'] }}</td>
                    <td class="currency">R$ {{ number_format($maquina['custo_total'], 2, ',', '.') }}</td>
                    <td class="currency">R$ {{ number_format($maquina['custo_total'] / $maquina['quantidade'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="section">
        <h2>📋 Detalhamento das Manutenções</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Máquina</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Custo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($manutencoes as $manutencao)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($manutencao->created_at)) }}</td>
                    <td>{{ $manutencao->maquina->nome }}</td>
                    <td>{{ ucfirst($manutencao->tipo) }}</td>
                    <td>{{ $manutencao->descricao }}</td>
                    <td class="currency">R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Gestor de Implementos - Sistema de Gestão Agrícola | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>