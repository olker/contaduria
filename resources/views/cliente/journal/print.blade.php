<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Libro Diario - {{ $company->name }}</title>
<style>
@page{size:A4 portrait;margin:15mm}*{box-sizing:border-box}body{font:11px Arial,sans-serif;color:#111}
.company{line-height:1.5}.heading{text-align:center;margin:18px 0 22px}.heading h1{font-size:16px;margin:0 0 5px}
.entry{margin:0 0 22px;break-inside:avoid}.entry-head{font-weight:bold;margin-bottom:6px}
table{width:100%;border-collapse:collapse}th,td{padding:5px 4px;border-bottom:1px solid #bbb}th{text-align:left}
.num{text-align:right;white-space:nowrap}.totals td{font-weight:bold;border-top:1px solid #333}
.glosa{font-style:italic;margin:7px 0 0 24px}.print-actions{margin-bottom:16px}
@media print{.print-actions{display:none}}
</style></head><body>
<div class="print-actions"><button onclick="window.print()">Imprimir / Guardar PDF</button></div>
<div class="company"><strong>{{ $company->name }}</strong><br>{{ $company->fiscal_address }}<br>NIT: {{ $company->nit }}</div>
<div class="heading"><h1>LIBRO DIARIO</h1>Gestión {{ $company->fiscal_period }} · Expresado en {{ $company->currency }}</div>
@foreach($entries as $entry)
<div class="entry">
    <div class="entry-head">{{ $entry->entry_code }} &nbsp; Fecha: {{ $entry->date->format('d/m/Y') }} &nbsp; {{ $entry->type === 'apertura' ? 'ASIENTO DE APERTURA' : 'ASIENTO DIARIO' }}</div>
    <table><thead><tr><th>DETALLE</th><th>FOLIO</th><th class="num">DEBE</th><th class="num">HABER</th></tr></thead><tbody>
    @foreach($entry->lines as $line)
        <tr><td>{{ $line->account->name }}@if($line->description)<br><small>{{ $line->description }}</small>@endif</td>
        <td>{{ $line->account->code }}</td>
        <td class="num">{{ (float)$line->debit > 0 ? number_format((float)$line->debit,2,',','.') : '' }}</td>
        <td class="num">{{ (float)$line->credit > 0 ? number_format((float)$line->credit,2,',','.') : '' }}</td></tr>
    @endforeach
    <tr class="totals"><td colspan="2">SUMAS IGUALES</td>
    <td class="num">{{ number_format($entry->lines->sum(fn($l)=>(float)$l->debit),2,',','.') }}</td>
    <td class="num">{{ number_format($entry->lines->sum(fn($l)=>(float)$l->credit),2,',','.') }}</td></tr>
    </tbody></table>
    <div class="glosa">Glosa: {{ $entry->description }}</div>
</div>
@endforeach
</body></html>