<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Produtividade</title>
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
        .numeric {
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
        .chart-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📈 Relatório de Produtividade</h1>
        <p>Período: {{ date('d/m/Y', strtotime($dataInicio)) }} a {{ date('d/m/Y', strtotime($dataFim)) }}</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @if($produtividadeOperadores->count() > 0)
    <div class="section">
        <h2>👥 Produtividade por Operador</h2>
        <table>
            <thead>
                <tr>
                    <th>Operador</th>
                    <th>Total de Horas</th>
                    <th>Total de Usos</th>
                    <th>Média por Uso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtividadeOperadores as $operador)
                <tr>
                    <td>{{ $operador['operador'] }}</td>
                    <td class="numeric">{{ number_format($operador['total_horas'], 1) }}h</td>
                    <td class="numeric">{{ $operador['total_usos'] }}</td>
                    <td class="numeric">{{ number_format($operador['media_horas_por_uso'], 1) }}h</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($produtividadeMaquinas->count() > 0)
    <div class="section">
        <h2>🚜 Produtividade por Máquina</h2>
        <table>
            <thead>
                <tr>
                    <th>Máquina</th>
                    <th>Total de Horas</th>
                    <th>Total de Usos</th>
                    <th>Média por Uso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtividadeMaquinas as $maquina)
                <tr>
                    <td>{{ $maquina['maquina'] }}</td>
                    <td class="numeric">{{ number_format($maquina['total_horas'], 1) }}h</td>
                    <td class="numeric">{{ $maquina['total_usos'] }}</td>
                    <td class="numeric">{{ number_format($maquina['media_horas_por_uso'], 1) }}h</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($usoPorDiaSemana->count() > 0)
    <div class="section">
        <h2>📅 Uso por Dia da Semana</h2>
        <div class="chart-section">
            <table>
                <thead>
                    <tr>
                        <th>Dia da Semana</th>
                        <th>Total de Horas</th>
                        <th>Percentual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalHorasSemana = $usoPorDiaSemana->sum();
                    @endphp
                    @foreach($usoPorDiaSemana as $dia => $horas)
                    <tr>
                        <td>{{ $dia }}</td>
                        <td class="numeric">{{ number_format($horas, 1) }}h</td>
                        <td class="numeric">{{ $totalHorasSemana > 0 ? number_format(($horas / $totalHorasSemana) * 100, 1) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="section">
        <h2>📊 Resumo Executivo</h2>
        <div class="chart-section">
            <table>
                <thead>
                    <tr>
                        <th>Métrica</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total de Operadores Ativos</td>
                        <td class="numeric">{{ $produtividadeOperadores->count() }}</td>
                    </tr>
                    <tr>
                        <td>Total de Máquinas Utilizadas</td>
                        <td class="numeric">{{ $produtividadeMaquinas->count() }}</td>
                    </tr>
                    <tr>
                        <td>Total de Horas Trabalhadas</td>
                        <td class="numeric">{{ number_format($produtividadeOperadores->sum('total_horas'), 1) }}h</td>
                    </tr>
                    <tr>
                        <td>Total de Usos Registrados</td>
                        <td class="numeric">{{ $produtividadeOperadores->sum('total_usos') }}</td>
                    </tr>
                    @if($produtividadeOperadores->count() > 0)
                    <tr>
                        <td>Operador Mais Produtivo</td>
                        <td class="numeric">{{ $produtividadeOperadores->first()['operador'] }} ({{ number_format($produtividadeOperadores->first()['total_horas'], 1) }}h)</td>
                    </tr>
                    @endif
                    @if($produtividadeMaquinas->count() > 0)
                    <tr>
                        <td>Máquina Mais Utilizada</td>
                        <td class="numeric">{{ $produtividadeMaquinas->first()['maquina'] }} ({{ number_format($produtividadeMaquinas->first()['total_horas'], 1) }}h)</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Gestor de Implementos - Sistema de Gestão Agrícola | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>