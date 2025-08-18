<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Uso de Máquinas</title>
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
        <h1>🚜 Relatório de Uso de Máquinas</h1>
        <p>Período: {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataFim)) }}</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-value">{{ $totalUsos }}</div>
            <div class="stat-label">Total de Usos</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ number_format($totalHoras, 1) }}h</div>
            <div class="stat-label">Total de Horas</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $totalUsos > 0 ? number_format($totalHoras / $totalUsos, 1) : 0 }}h</div>
            <div class="stat-label">Média por Uso</div>
        </div>
    </div>

    @if($maquinasMaisUsadas->count() > 0)
    <div class="section">
        <h2>📊 Máquinas Mais Utilizadas</h2>
        <table>
            <thead>
                <tr>
                    <th>Máquina</th>
                    <th>Total de Horas</th>
                    <th>Quantidade de Usos</th>
                    <th>Média por Uso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maquinasMaisUsadas as $maquina)
                <tr>
                    <td>{{ $maquina['nome'] }}</td>
                    <td>{{ number_format($maquina['total_horas'], 1) }}h</td>
                    <td>{{ $maquina['total_usos'] }}</td>
                    <td>{{ number_format($maquina['total_horas'] / $maquina['total_usos'], 1) }}h</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="section">
        <h2>📋 Detalhamento dos Usos</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Máquina</th>
                    <th>Operador</th>
                    <th>Tarefa</th>
                    <th>Horas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usos as $uso)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($uso->data)) }}</td>
                    <td>{{ $uso->maquina->nome }}</td>
                    <td>{{ $uso->operador->nome }}</td>
                    <td>{{ $uso->tarefa }}</td>
                    <td>{{ number_format($uso->total_horas, 1) }}h</td>
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