<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTestCompanies extends Command
{
    protected $signature = 'contaduria:reset-test-companies {--force : Ejecuta la limpieza sin solicitar confirmación}';

    protected $description = 'Elimina empresas y movimientos contables de prueba, conservando usuarios y catálogo maestro.';

    public function handle()
    {
        $companies = DB::table('companies')->count();
        $entries = DB::table('journal_entries')->count();
        $transactions = DB::table('transactions')->count();

        $this->table(
            ['Dato', 'Registros que se eliminarán'],
            [
                ['Empresas', $companies],
                ['Asientos del Libro Diario', $entries],
                ['Transacciones', $transactions],
            ]
        );

        $this->warn('Se conservarán todos los usuarios, contraseñas, roles, membresías y el catálogo maestro de cuentas.');
        $this->warn('También se conservarán las tablas maestras accounts y plan_accounts.');

        if (!$this->option('force') && !$this->confirm('¿Confirmas que estos datos son de prueba y deseas eliminarlos?')) {
            $this->info('Operación cancelada. No se modificó la base de datos.');
            return self::SUCCESS;
        }

        DB::transaction(function () {
            // Las líneas se eliminan por cascade al borrar los asientos.
            DB::table('journal_entries')->delete();
            DB::table('transactions')->delete();
            DB::table('companies')->delete();
        });

        $this->info('Limpieza completada. Las cuentas de usuario y el catálogo contable se conservaron.');
        return self::SUCCESS;
    }
}
