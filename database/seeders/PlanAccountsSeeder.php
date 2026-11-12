<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanAccountsSeeder extends Seeder
{
    public function run()
    {
        $entries = json_decode(<<<'JSON'
[
    {
        "source_order": 1,
        "code": "1",
        "name": "ACTIVO",
        "parent_source_order": null,
        "group_type": "activo",
        "level": 1,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 2,
        "code": "1.1",
        "name": "ACTIVO CORRIENTE O CIRCULANTE",
        "parent_source_order": 1,
        "group_type": "activo",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 3,
        "code": "1.1.1",
        "name": "DISPONIBLE",
        "parent_source_order": 2,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 4,
        "code": "1.1.1.1",
        "name": "Caja Moneda Nacional",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 5,
        "code": "1.1.1.2",
        "name": "Caja moneda extranjera",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 6,
        "code": "1.1.1.3",
        "name": "Caja chica",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 7,
        "code": "1.1.1.4",
        "name": "Bancos",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 8,
        "code": "1.1.1.5",
        "name": "Caja de ahorro Moneda nacional",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 9,
        "code": "1.1.1.6",
        "name": "Caja de ahorro Moneda extranjera",
        "parent_source_order": 3,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 10,
        "code": "1.1.2",
        "name": "EXIGIBLE",
        "parent_source_order": 2,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 11,
        "code": "1.1.2.1",
        "name": "Cuentas por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 12,
        "code": "1.1.2.2",
        "name": "Documentos por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 13,
        "code": "1.1.2.3",
        "name": "Alquileres por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 14,
        "code": "1.1.2.4",
        "name": "IVA – Crédito Fiscal",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 15,
        "code": "1.1.2.5",
        "name": "Intereses por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 16,
        "code": "1.1.2.6",
        "name": "Comisiones por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 17,
        "code": "1.1.2.7",
        "name": "Anticipo de sueldos",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 18,
        "code": "1.1.2.8",
        "name": "Préstamos por cobrar",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 19,
        "code": "1.1.2.9",
        "name": "Anticipo a proveedores",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 20,
        "code": "1.1.2.10",
        "name": "Anticipo de sueldos",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 21,
        "code": "1.1.2.11",
        "name": "Depósitos a plazo fijo",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 22,
        "code": "1.1.2.12",
        "name": "Cuenta corriente socios",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 23,
        "code": "1.1.2.13",
        "name": "Cuentas incobrables",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 24,
        "code": "1.1.2.14",
        "name": "(-) Previsión para Cuentas Incobrables",
        "parent_source_order": 10,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 25,
        "code": "1.1.3",
        "name": "REALIZABLE",
        "parent_source_order": 2,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 26,
        "code": "1.1.3.1",
        "name": "Inventario Inicial de Mercaderías-Inventario final de mercaderías",
        "parent_source_order": 25,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 27,
        "code": "1.1.3.2",
        "name": "Material de Escritorio",
        "parent_source_order": 25,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 28,
        "code": "1.1.3.3",
        "name": "Material de limpieza",
        "parent_source_order": 25,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 29,
        "code": "1.2",
        "name": "ACTIVO NO CORRIENTE",
        "parent_source_order": 1,
        "group_type": "activo",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 30,
        "code": "1.2.1",
        "name": "ACTIVO FIJO",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 31,
        "code": "1.2.1.1",
        "name": "Terrenos",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 32,
        "code": "1.2.1.2",
        "name": "Edificios",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 33,
        "code": "1.2.1.3",
        "name": "Muebles y enseres (Escritorios, Estantes, Fotocopiadoras, Aparatos Telefónicos, Máquinas de calcular y otros)",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 34,
        "code": "1.2.1.4",
        "name": "Equipo de computación",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 35,
        "code": "1.2.1.5",
        "name": "Vehículos (Motocicletas)",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 36,
        "code": "1.2.1.6",
        "name": "Maquinaria y Equipo",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 37,
        "code": "1.2.1.7",
        "name": "Herramientas",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 38,
        "code": "1.2.1.8",
        "name": "Equipo de Comunicación (Celulares, radios)",
        "parent_source_order": 30,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 39,
        "code": "1.2.2",
        "name": " .DEPRECIACIÓN ACUMULADA ACTIVO FIJO (En el Balance General va a Restar al Activo Fijo y en la Hoja de trabajo va al Pasivo)",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 40,
        "code": "1.2.2.1.",
        "name": "Depreciación Acumulada de Edificios",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 41,
        "code": "1.2.2.2",
        "name": "Depreciación Acumulada de Muebles y Enseres",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 42,
        "code": "1.2.2.3",
        "name": "Depreciación Acumulada de Vehículos",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 43,
        "code": "1.2.2.4",
        "name": "Depreciación Acumulada de Equipo de Computación",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 44,
        "code": "1.2.2.5",
        "name": "Depreciación Acumulada de Herramientas",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 45,
        "code": "1.2.2.6",
        "name": "Depreciación Acumulada Maquinarias y Equipos",
        "parent_source_order": 39,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 46,
        "code": "1.2.3",
        "name": "INVERSIONES",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 47,
        "code": "1.2.3.1",
        "name": "Inversión en Acciones (Línea telefónica)",
        "parent_source_order": 46,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 48,
        "code": "1.2.3.2",
        "name": "Inversión en Bonos",
        "parent_source_order": 46,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 49,
        "code": "1.2.4",
        "name": "TRANSITORIO",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 50,
        "code": "1.2.4.1",
        "name": "Mercadería en tránsito",
        "parent_source_order": 49,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 51,
        "code": "1.2.4.2",
        "name": "Obras en construcción",
        "parent_source_order": 49,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 52,
        "code": "1.2.5",
        "name": "DIFERIDO",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 53,
        "code": "1.2.5.1",
        "name": "Gastos de organización (trámites, pago notario, gastos de transporte,..",
        "parent_source_order": 52,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 54,
        "code": "1.2.5.2",
        "name": "Gastos de Instalación",
        "parent_source_order": 52,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 55,
        "code": "1.2.6",
        "name": "GASTOS PAGADOS POR ANTICIPADO",
        "parent_source_order": 29,
        "group_type": "activo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 1
    },
    {
        "source_order": 56,
        "code": "1.2.6.1",
        "name": "Seguros Pagados por Anticipado",
        "parent_source_order": 55,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 57,
        "code": "1.2.6.2",
        "name": "Alquileres Pagados por Anticipado",
        "parent_source_order": 55,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 58,
        "code": "1.2.6.3",
        "name": "Comisiones Pagados por Anticipado",
        "parent_source_order": 55,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 59,
        "code": "1.2.6.4",
        "name": "Intereses Pagados por Anticipado",
        "parent_source_order": 55,
        "group_type": "activo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 1
    },
    {
        "source_order": 60,
        "code": "2",
        "name": "PASIVO",
        "parent_source_order": null,
        "group_type": "pasivo",
        "level": 1,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 61,
        "code": "2.1",
        "name": "PASIVO CORRIENTE O CIRCULANTE",
        "parent_source_order": 60,
        "group_type": "pasivo",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 62,
        "code": "2.1.1",
        "name": "EXIGIBLE",
        "parent_source_order": 61,
        "group_type": "pasivo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 63,
        "code": "2.1.1.1",
        "name": "Cuentas por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 64,
        "code": "2.1.1.2",
        "name": "Documentos por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 65,
        "code": "2.1.1.3",
        "name": "IVA- Debito fiscal",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 66,
        "code": "2.1.1.4",
        "name": "Impuesto a las transacciones por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 67,
        "code": "2.1.1.5",
        "name": "Sueldos por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 68,
        "code": "2.1.1.6",
        "name": "Alquileres por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 69,
        "code": "2.1.1.7",
        "name": "Comisiones por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 70,
        "code": "2.1.1.8",
        "name": "Interés por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 71,
        "code": "2.1.1.9",
        "name": "Retenciones por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 72,
        "code": "2.1.1.10",
        "name": "Anticipo de clientes",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 73,
        "code": "2.1.1.11",
        "name": "Imp. A las utilidades de empresas por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 74,
        "code": "2.1.1.12",
        "name": "Honorarios por Pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 75,
        "code": "2.1.1.13",
        "name": "Aportes por pagar",
        "parent_source_order": 62,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 76,
        "code": "2.2",
        "name": "PASIVO NO CORRIENTE",
        "parent_source_order": 60,
        "group_type": "pasivo",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 77,
        "code": "2.2.1",
        "name": "PASIVO A LARGO PLAZO",
        "parent_source_order": 76,
        "group_type": "pasivo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 78,
        "code": "2.2.1.1",
        "name": "Préstamo bancario por pagar",
        "parent_source_order": 77,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 79,
        "code": "2.2.1.2",
        "name": "Hipotecas por pagar",
        "parent_source_order": 77,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 80,
        "code": "2.2.2",
        "name": "INGRESOS COBRADOS POR ANTICIPADO",
        "parent_source_order": 76,
        "group_type": "pasivo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 81,
        "code": "2.2.2.1",
        "name": "Alquileres Cobrados por Anticipado",
        "parent_source_order": 80,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 82,
        "code": "2.2.2.2",
        "name": "Comisiones cobrados por Anticipado",
        "parent_source_order": 80,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 83,
        "code": "2.2.2.3",
        "name": "Intereses Cobrados por Anticipado",
        "parent_source_order": 80,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 84,
        "code": "2.2.3",
        "name": "PROVISIONES Y PREVISIONES",
        "parent_source_order": 76,
        "group_type": "pasivo",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 2
    },
    {
        "source_order": 85,
        "code": "2.2.3.1",
        "name": "Provisión para Aguinaldos",
        "parent_source_order": 84,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 86,
        "code": "2.2.3.2",
        "name": "Previsión para Indemnizaciones",
        "parent_source_order": 84,
        "group_type": "pasivo",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 2
    },
    {
        "source_order": 87,
        "code": "3",
        "name": "PATRIMONIO (CAPITAL, RESERVAS Y RESULTADOS)",
        "parent_source_order": null,
        "group_type": "patrimonio",
        "level": 1,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 88,
        "code": "3.1",
        "name": "CAPITAL",
        "parent_source_order": 87,
        "group_type": "patrimonio",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 89,
        "code": "3.1.1.",
        "name": "CAPITAL",
        "parent_source_order": 88,
        "group_type": "patrimonio",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 90,
        "code": "3.1.1.1",
        "name": "Capital Social",
        "parent_source_order": 89,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 91,
        "code": "3.2",
        "name": "RESERVAS",
        "parent_source_order": 87,
        "group_type": "patrimonio",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 92,
        "code": "3.2.1.",
        "name": "RESERVAS",
        "parent_source_order": 91,
        "group_type": "patrimonio",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 93,
        "code": "3.2.1.",
        "name": "Reserva Legal",
        "parent_source_order": 92,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 94,
        "code": "3.2.1.2",
        "name": "Reserva para revalorización de Activos Fijos",
        "parent_source_order": 92,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 95,
        "code": "3.2.1.3",
        "name": "Ajuste de Capital",
        "parent_source_order": 92,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 96,
        "code": "3.2.1.4",
        "name": "Ajuste de Reservas Patrimoniales",
        "parent_source_order": 92,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 97,
        "code": "3.3",
        "name": "RESULTADOS",
        "parent_source_order": 87,
        "group_type": "patrimonio",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 98,
        "code": "3.3.1",
        "name": "RESULTADOS",
        "parent_source_order": 97,
        "group_type": "patrimonio",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 99,
        "code": "3.3.1.1",
        "name": "Utilidad o Pérdida de la Gestión",
        "parent_source_order": 98,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 100,
        "code": "3.3.1.2",
        "name": "Utilidades o Pérdidas de Gestiones anteriores",
        "parent_source_order": 98,
        "group_type": "patrimonio",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 101,
        "code": "4",
        "name": "INGRESOS",
        "parent_source_order": null,
        "group_type": "ingreso",
        "level": 1,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 102,
        "code": "4.1",
        "name": "INGRESOS ORDINARIOS",
        "parent_source_order": 101,
        "group_type": "ingreso",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 103,
        "code": "4.1.1",
        "name": "Ventas",
        "parent_source_order": 102,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 104,
        "code": "4.1.2",
        "name": "Recargo en ventas",
        "parent_source_order": 102,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 105,
        "code": "4.1.3",
        "name": "Devolución en compras",
        "parent_source_order": 102,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 106,
        "code": "4.1.4",
        "name": "Descuento en compras",
        "parent_source_order": 102,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 107,
        "code": "4.1.2",
        "name": "INGRESOS EXTRAORDINARIOS",
        "parent_source_order": 101,
        "group_type": "ingreso",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 3
    },
    {
        "source_order": 108,
        "code": "4.1.2.1",
        "name": "Alquileres percibidos (ganados)",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 109,
        "code": "4.1.2.2",
        "name": "Comisiones percibidos",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 110,
        "code": "4.1.2.3",
        "name": "Intereses ganados",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 111,
        "code": "4.1.2.4",
        "name": "Ingresos Varios",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 112,
        "code": "4.1.2.5",
        "name": "Utilidad en venta de Activos Fijos",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 113,
        "code": "4.1.2.6",
        "name": "Diferencia de cambio (saldo acreedor)",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 114,
        "code": "4.1.2.7",
        "name": "Pérdidas y Ganancias",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 115,
        "code": "4.1.2.8",
        "name": "Ajuste por Inflación y Tenencia de Bienes",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 116,
        "code": "4.1.2.9",
        "name": "Mantenimiento de Valor",
        "parent_source_order": 107,
        "group_type": "ingreso",
        "level": 3,
        "is_group": false,
        "allows_entries": true,
        "source_page": 3
    },
    {
        "source_order": 117,
        "code": "5",
        "name": "GASTOS",
        "parent_source_order": null,
        "group_type": "gasto",
        "level": 1,
        "is_group": true,
        "allows_entries": false,
        "source_page": 4
    },
    {
        "source_order": 118,
        "code": "5.1",
        "name": "GASTOS",
        "parent_source_order": 117,
        "group_type": "gasto",
        "level": 2,
        "is_group": true,
        "allows_entries": false,
        "source_page": 4
    },
    {
        "source_order": 119,
        "code": "5.1.1",
        "name": "COSTO DE VENTAS",
        "parent_source_order": 118,
        "group_type": "gasto",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 4
    },
    {
        "source_order": 120,
        "code": "5.1.1",
        "name": "Compras",
        "parent_source_order": 119,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 121,
        "code": "5.1.2",
        "name": "Recargo en compras",
        "parent_source_order": 119,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 122,
        "code": "51.3",
        "name": "Inventario Inicial de Mercaderías",
        "parent_source_order": 119,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 123,
        "code": "5.1.4",
        "name": "Devolución en ventas",
        "parent_source_order": 119,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 124,
        "code": "5.1.5",
        "name": "Descuento en ventas",
        "parent_source_order": 119,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 125,
        "code": "5.1.2",
        "name": "GASTOS ORDINARIOS",
        "parent_source_order": 118,
        "group_type": "gasto",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 4
    },
    {
        "source_order": 126,
        "code": "5.1.2.1",
        "name": "Gastos Generales (pago de luz, agua, teléfono, gas)",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 127,
        "code": "5.1.2.2",
        "name": "Sueldos y salarios",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 128,
        "code": "5.1.2.3",
        "name": "Seguros",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 129,
        "code": "5.1.2.4",
        "name": "Alquileres",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 130,
        "code": "5.1.2.5",
        "name": "Intereses",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 131,
        "code": "5.1.2.6",
        "name": "Comisiones",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 132,
        "code": "5.1.2.7",
        "name": "Gastos bancarios",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 133,
        "code": "5.1.2.8",
        "name": "Material de Escritorio consumido",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 134,
        "code": "5.1.2.9",
        "name": "Castigo Cuentas Incobrables",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 135,
        "code": "5.1.2.10",
        "name": "Depreciación Edificios",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 136,
        "code": "5.1.2.11",
        "name": "Depreciación Muebles y Enseres",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 137,
        "code": "5.1.2.12",
        "name": "Depreciación Equipo de Computación",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 138,
        "code": "5.2.13",
        "name": "Depreciación Vehículos",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 139,
        "code": "5.1.2.14",
        "name": "Depreciación Herramientas",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 140,
        "code": "5.1.2.15",
        "name": "Impuesto a las transacciones",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 141,
        "code": "5.1.2.16",
        "name": "Amortización Gastos de Organización",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 142,
        "code": "5.1.2.17",
        "name": "Aguinaldos",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 143,
        "code": "5.1.2.18",
        "name": "Amortización Gastos de Instalación",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 144,
        "code": "5.1.2.19",
        "name": "Aguinaldos",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 145,
        "code": "5.1.2.20",
        "name": "Pasajes y Viático",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 146,
        "code": "5.1.2.21",
        "name": "ajustes por inflación y tenencia de bienes (saldo deudor",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 147,
        "code": "5.1.2.22",
        "name": "diferencia de cambio (saldo deudor)",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 148,
        "code": "5.1.2.23",
        "name": "Impuesto sobre las utilidades de las Empresas",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 149,
        "code": "5.1.2.24",
        "name": "Patentes Municipales",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 150,
        "code": "5.1.2.25",
        "name": "Beneficios Sociales",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 151,
        "code": "5.1.2.26",
        "name": "Aportes Patronales",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 152,
        "code": "5.1.2.27",
        "name": "Publicidad y Propaganda",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 153,
        "code": "5.1.2.28",
        "name": "Honorarios Profesionales",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 154,
        "code": "5.1.2.29",
        "name": "Aguinaldos",
        "parent_source_order": 125,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 155,
        "code": "5.1.3",
        "name": "GASTOS EXTRAORDINARIOS",
        "parent_source_order": 118,
        "group_type": "gasto",
        "level": 3,
        "is_group": true,
        "allows_entries": false,
        "source_page": 4
    },
    {
        "source_order": 156,
        "code": "5.1.3.1",
        "name": "Multas y Sanciones",
        "parent_source_order": 155,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 157,
        "code": "5.1.3.1",
        "name": "Pérdida en Venta de Activos Fijos",
        "parent_source_order": 155,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    },
    {
        "source_order": 158,
        "code": "5.1.3.3",
        "name": "Donaciones",
        "parent_source_order": 155,
        "group_type": "gasto",
        "level": 4,
        "is_group": false,
        "allows_entries": true,
        "source_page": 4
    }
]
JSON, true);

        DB::transaction(function () use ($entries) {
            $ids = [];

            foreach ($entries as $entry) {
                $parentId = $entry['parent_source_order'] === null
                    ? null
                    : ($ids[$entry['parent_source_order']] ?? null);

                $values = [
                    'code' => $entry['code'],
                    'name' => $entry['name'],
                    'parent_id' => $parentId,
                    'group_type' => $entry['group_type'],
                    'level' => $entry['level'],
                    'is_group' => $entry['is_group'],
                    'allows_entries' => $entry['allows_entries'],
                    'source_page' => $entry['source_page'],
                    'updated_at' => now(),
                ];

                $existingId = DB::table('plan_accounts')
                    ->where('source_order', $entry['source_order'])
                    ->value('id');

                if ($existingId) {
                    DB::table('plan_accounts')->where('id', $existingId)->update($values);
                    $ids[$entry['source_order']] = $existingId;
                } else {
                    $values['source_order'] = $entry['source_order'];
                    $values['created_at'] = now();
                    $ids[$entry['source_order']] = DB::table('plan_accounts')->insertGetId($values);
                }
            }

            $observations = [
                [
                    'observation_key' => 'duplicate-code-3-2-1',
                    'plan_account_id' => $ids[92],
                    'issue_type' => 'codigo_repetido',
                    'description' => 'El código 3.2.1 aparece para el encabezado RESERVAS y también para la cuenta Reserva Legal. Se conserva la puntuación impresa en cada aparición.',
                    'source_excerpt' => '3.2.1. RESERVAS / 3.2.1. Reserva Legal',
                    'source_page' => 3,
                ],
                [
                    'observation_key' => 'duplicate-code-4-1-2',
                    'plan_account_id' => $ids[107],
                    'issue_type' => 'codigo_repetido',
                    'description' => 'El código 4.1.2 aparece como cuenta Recargo en ventas y nuevamente como encabezado INGRESOS EXTRAORDINARIOS.',
                    'source_excerpt' => '4.1.2 Recargo en ventas / 4.1.2 INGRESOS EXTRAORDINARIOS',
                    'source_page' => 3,
                ],
                [
                    'observation_key' => 'duplicate-code-5-1-1',
                    'plan_account_id' => $ids[120],
                    'issue_type' => 'codigo_repetido',
                    'description' => 'El código 5.1.1 aparece como encabezado COSTO DE VENTAS y como cuenta Compras.',
                    'source_excerpt' => '5.1.1 COSTO DE VENTAS / 5.1.1 Compras',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'duplicate-code-5-1-2',
                    'plan_account_id' => $ids[125],
                    'issue_type' => 'codigo_repetido',
                    'description' => 'El código 5.1.2 aparece como cuenta Recargo en compras y como encabezado GASTOS ORDINARIOS.',
                    'source_excerpt' => '5.1.2 Recargo en compras / 5.1.2 GASTOS ORDINARIOS',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'code-51-3-format',
                    'plan_account_id' => $ids[122],
                    'issue_type' => 'formato_de_codigo',
                    'description' => 'El código se imprime como 51.3, sin el punto separador después del primer dígito, mientras las cuentas vecinas usan el patrón 5.1.x. No se modifica.',
                    'source_excerpt' => '51.3 Inventario Inicial de Mercaderías',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'code-5-2-13-outlier',
                    'plan_account_id' => $ids[138],
                    'issue_type' => 'numeracion_inconsistente',
                    'description' => 'El código 5.2.13 aparece entre cuentas del bloque 5.1.2.x. Se conserva exactamente como está impreso.',
                    'source_excerpt' => '5.2.13 Depreciación Vehículos',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'duplicate-code-5-1-3-1',
                    'plan_account_id' => $ids[157],
                    'issue_type' => 'codigo_repetido',
                    'description' => 'El código 5.1.3.1 se asigna a dos cuentas distintas: Multas y Sanciones y Pérdida en Venta de Activos Fijos.',
                    'source_excerpt' => '5.1.3.1 Multas y Sanciones / 5.1.3.1 Pérdida en Venta de Activos Fijos',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'duplicate-name-anticipo-sueldos',
                    'plan_account_id' => $ids[20],
                    'issue_type' => 'nombre_repetido',
                    'description' => 'El nombre Anticipo de sueldos aparece en las cuentas 1.1.2.7 y 1.1.2.10.',
                    'source_excerpt' => '1.1.2.7 Anticipo de sueldos / 1.1.2.10 Anticipo de sueldos',
                    'source_page' => 1,
                ],
                [
                    'observation_key' => 'duplicate-name-aguinaldos',
                    'plan_account_id' => $ids[154],
                    'issue_type' => 'nombre_repetido',
                    'description' => 'El nombre Aguinaldos aparece en las cuentas 5.1.2.17, 5.1.2.19 y 5.1.2.29.',
                    'source_excerpt' => '5.1.2.17 Aguinaldos / 5.1.2.19 Aguinaldos / 5.1.2.29 Aguinaldos',
                    'source_page' => 4,
                ],
                [
                    'observation_key' => 'trailing-period-codes',
                    'plan_account_id' => $ids[40],
                    'issue_type' => 'formato_de_codigo',
                    'description' => 'Algunos códigos aparecen con punto final, por ejemplo 1.2.2.1., 3.1.1. y 3.2.1. Se conserva cada representación original.',
                    'source_excerpt' => '1.2.2.1. Depreciación Acumulada de Edificios / 3.1.1. CAPITAL / 3.2.1. Reserva Legal',
                    'source_page' => 2,
                ],
                [
                    'observation_key' => 'depreciation-note',
                    'plan_account_id' => $ids[39],
                    'issue_type' => 'nota_del_documento',
                    'description' => 'El PDF indica que la depreciación acumulada resta al Activo Fijo en el Balance General y va al Pasivo en la Hoja de Trabajo. Esta indicación se conserva como nota del documento; no altera el grupo del catálogo.',
                    'source_excerpt' => 'En el Balance General va a Restar al Activo Fijo y en la Hoja de trabajo va al Pasivo.',
                    'source_page' => 1,
                ],
                [
                    'observation_key' => 'inventory-account-label',
                    'plan_account_id' => $ids[26],
                    'issue_type' => 'observacion_de_nombre',
                    'description' => 'El nombre de la cuenta contiene simultáneamente las expresiones Inventario Inicial e Inventario final, unidas por guion. Se conserva sin interpretación.',
                    'source_excerpt' => 'Inventario Inicial de Mercaderías-Inventario final de mercaderías',
                    'source_page' => 1,
                ],
                [
                    'observation_key' => 'expense-name-unclosed-parenthesis',
                    'plan_account_id' => $ids[146],
                    'issue_type' => 'observacion_de_nombre',
                    'description' => 'El nombre de la cuenta aparece con paréntesis de apertura y sin cierre. Se conserva literalmente.',
                    'source_excerpt' => '5.1.2.21 ajustes por inflación y tenencia de bienes (saldo deudor',
                    'source_page' => 4,
                ],
            ];

            foreach ($observations as $observation) {
                $observation['updated_at'] = now();
                $existingId = DB::table('plan_account_observations')
                    ->where('observation_key', $observation['observation_key'])
                    ->value('id');

                if ($existingId) {
                    DB::table('plan_account_observations')->where('id', $existingId)->update($observation);
                } else {
                    $observation['created_at'] = now();
                    DB::table('plan_account_observations')->insert($observation);
                }
            }
        });
    }
}
