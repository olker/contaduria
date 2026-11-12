<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Balance de Apertura - {{ $company->name }}</title>
<style>
@page { size:A4 portrait; margin:18mm 16mm; }
*{box-sizing:border-box} body{font-family:Arial,sans-serif;color:#111;font-size:12px}
.company{line-height:1.55;font-size:12px}.title{text-align:center;margin:20px 0 36px;line-height:1.7}
.title h1{font-size:16px;margin:0}.columns{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start}
.column h2{font-size:13px;text-decoration:underline;margin:0 0 14px}
.section{margin:0 0 22px;break-inside:avoid}.section-title{font-weight:bold;text-decoration:underline;margin:0 0 10px;text-transform:uppercase}
table{width:100%;border-collapse:collapse}td{padding:4px 0;vertical-align:top}td.amount{text-align:right;white-space:nowrap;width:90px}
.totals{display:flex;justify-content:space-between;gap:20px;margin-top:32px;font-weight:bold;font-size:14px}
.print-actions{margin:0 0 18px}button{padding:9px 16px;cursor:pointer}
@media print{.print-actions{display:none}}
</style>
</head>
<body>
<div class="print-actions"><button onclick="window.print()">Imprimir / Guardar PDF</button></div>
<div class="company"><strong>{{ $company->name }}</strong><br>{{ $company->fiscal_address }}<br>NIT: {{ $company->nit }}<br>Cochabamba - Bolivia</div>
<div class="title"><h1>BALANCE DE APERTURA</h1>
Realizado al {{ $entry->date->format('d/m/Y') }}<br>
(Expresado en {{ $company->currency === 'BOB' ? 'bolivianos' : 'dólares estadounidenses' }})</div>
<div class="columns">
<div class="column"><h2>ACTIVO</h2>
@foreach ($activeGroups as $section => $items)
<div class="section"><div class="section-title">{{ $section }}</div><table>
@foreach ($items as $item)<tr><td>{{ $item['name'] }}</td><td class="amount">{{ number_format($item['debit'],2,',','.') }}.-</td></tr>@endforeach
</table></div>
@endforeach
</div>
<div class="column"><h2>PASIVO</h2>
@foreach ($rightGroups['pasivo'] as $section => $items)
<div class="section"><div class="section-title">{{ $section }}</div><table>
@foreach ($items as $item)<tr><td>{{ $item['name'] }}</td><td class="amount">{{ number_format($item['credit'],2,',','.') }}.-</td></tr>@endforeach
</table></div>
@endforeach
<div class="section" style="margin-top:42px"><h2>CAPITAL Y RESERVA</h2>
@foreach ($rightGroups['patrimonio'] as $section => $items)
<div class="section"><div class="section-title">{{ $section }}</div><table>
@foreach ($items as $item)<tr><td>{{ $item['name'] }}</td><td class="amount">{{ number_format($item['credit'],2,',','.') }}.-</td></tr>@endforeach
</table></div>
@endforeach
</div>
</div>
</div>
<div class="totals"><div>TOTAL ACTIVO &nbsp; {{ number_format($totalActive,2,',','.') }}.-</div>
<div>TOTAL PASIVO Y CAPITAL &nbsp; {{ number_format($totalRight,2,',','.') }}.-</div></div>
</body></html>