<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\Tenant;
use App\Models\Manager;
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/rmdb/{tenant}', function ($tenantId) {


    $tenant = App\Models\Tenant::findOrFail($tenantId);
    $tenancyConfig = config('tenancy');
    $databaseConnectionName = env('DB_CONNECTION', 'central');

    $jsonData = json_decode($tenant->data, true);
    $databaseName = $tenant->tenancy_db_name ?? null;
    
    if (empty($databaseName)) {
        Log::error("Tenant database name not found for tenant ID: {$tenant->id}");
        return 'Tenant database name not found';
    }


    $sql = "DROP DATABASE IF EXISTS `$databaseName`";

    try {
        // Execute the SQL query using the specified database connection
        DB::connection($databaseConnectionName)->statement($sql);
        
        // Log success message
        Log::info("Tenant database '$databaseName' dropped successfully for tenant ID: {$tenant->id}");

        // Optionally return a success response
        return 'Tenant database dropped successfully';
    } catch (\Exception $e) {
        // Log error message
        Log::error("Failed to drop tenant database '$databaseName' for tenant ID: {$tenant->id}. Error: {$e->getMessage()}");
        
        // Optionally return an error response
        return 'Failed to drop tenant database';
    }
});
