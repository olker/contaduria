# Implementación inicial: Plan de Cuentas y Libro de Apertura

Este paquete contiene únicamente archivos nuevos o modificados para integrarlos en el proyecto `contaduria`.
No contiene `.env`, credenciales, `vendor`, `node_modules` ni archivos de Git.

## Qué incorpora

1. Catálogo central `plan_accounts` con los 158 renglones jerárquicos del Plan de Cuentas PDF.
2. Códigos y nombres almacenados literalmente como texto. No hay índice único sobre `code`, porque el documento contiene códigos repetidos.
3. Orden de origen (`source_order`) para conservar el orden del PDF y permitir que el seeder sea repetible.
4. Tabla `plan_account_observations` con las inconsistencias detectadas, sin corregir los códigos ni los nombres.
5. Relación de los nuevos asientos con `company_id`, manteniendo ese campo nullable para no romper asientos anteriores.
6. Tabla normalizada `journal_entry_lines` para guardar cada cuenta, Debe y Haber.
7. Módulo inicial de Libro de Apertura, limitado a cuentas auxiliares de Activo, Pasivo y Patrimonio.
8. Validación del periodo fiscal y del equilibrio Debe = Haber.
9. Acceso desde el dashboard y pantalla de observaciones del PDF.

## Instalación segura

1. Haz una copia de seguridad de tu base de datos MySQL y del proyecto.
2. Copia las carpetas/archivos de este paquete dentro de la carpeta raíz de tu proyecto `contaduria`, respetando las rutas y permitiendo reemplazar los archivos indicados.
3. Desde CMD, entra a la carpeta del proyecto:
   ```bat
   cd /d C:\xampp\htdocs\contaduria
   ```
4. Ejecuta las migraciones nuevas:
   ```bat
   php artisan migrate
   ```
5. Carga el catálogo:
   ```bat
   php artisan db:seed --class=PlanAccountsSeeder
   ```
6. Limpia cachés de Laravel:
   ```bat
   php artisan optimize:clear
   ```

**No ejecutes `php artisan migrate:fresh` ni `migrate:refresh`**, porque esos comandos pueden borrar las tablas y los datos existentes.

## Consideraciones

- El catálogo es común para todas las empresas; los asientos quedan asociados a la empresa propietaria.
- La migración agrega `company_id` como nullable para conservar registros históricos existentes. Los nuevos asientos de apertura sí lo guardan.
- El campo JSON `journal_entries.details` se mantiene y se llena para compatibilidad con la estructura previa; además, el nuevo detalle se guarda en `journal_entry_lines`.
- Por ahora se permite registrar un único asiento de apertura por empresa. La edición o sustitución de un asiento existente no está habilitada todavía.
- El módulo de Transacciones, Libro Diario general, Libro Mayor y Hoja de Trabajo no se implementan en este paquete.

## Verificaciones realizadas

- Sintaxis PHP de migraciones, modelos, seeder, controlador y rutas.
- Compilación de las vistas Blade modificadas/nuevas.
- Registro de las cuatro rutas `opening.*` mediante `php artisan route:list`.

No se ejecutaron las migraciones contra tu base MySQL real desde este entorno. Debes hacer la copia de seguridad y aplicar los comandos en tu XAMPP.
