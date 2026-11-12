@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registro de Datos de la Empresa</h2>
    <form action="{{ route('company.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Razón Social / Nombre de la Empresa</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="nit" class="form-label">Número de Identificación Tributaria (NIT)</label>
            <input type="text" class="form-control" id="nit" name="nit" required>
        </div>

        <div class="mb-3">
            <label for="society_type" class="form-label">Tipo de Sociedad</label>
            <select class="form-control" id="society_type" name="society_type" required>
                <option value="">Seleccione el tipo de sociedad</option>
                <option value="Unipersonal">Empresa Unipersonal</option>
                <option value="S.R.L.">Sociedad de Responsabilidad Limitada (S.R.L.)</option>
                <option value="S.A.">Sociedad Anónima (S.A.)</option>
                <option value="Comandita">Sociedad en Comandita</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="economic_activity" class="form-label">Actividad Económica Principal</label>
            <input type="text" class="form-control" id="economic_activity" name="economic_activity">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección / Domicilio Fiscal</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>

        <div class="mb-3">
            <label for="legal_representative" class="form-label">Representante Legal</label>
            <input type="text" class="form-control" id="legal_representative" name="legal_representative">
        </div>

        <button type="submit" class="btn btn-success">Guardar y Continuar al Balance Inicial</button>
    </form>
</div>
@endsection