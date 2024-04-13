<?php

namespace App\Observers\Tenancy;

use App\Models\Manager;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class cleanupTenancyObserver
{
    public function deleting(Manager $manager)
    {
        $this->dropTenancyDatabase($manager);
    }

    protected function dropTenancyDatabase(Manager $manager)
    {
        $databaseConnectionName = env('T_DB_CONNECTION', 'tenancies');
        $databaseName = $manager->tenant->tenancy_db_name;

        if (empty($databaseName) || !$manager->tenant->exists) {
            return;
        }

        $sql = "DROP DATABASE IF EXISTS `$databaseName`";

        try {
            DB::connection($databaseConnectionName)->statement($sql);
            $manager->tenant->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}