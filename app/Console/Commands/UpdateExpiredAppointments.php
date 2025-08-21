<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateExpiredAppointments extends Command
{
    protected $signature = 'appointments:update-expired';
    protected $description = 'Update expired appointments to status "expired" if 5 minutes late';

    public function handle()
    {
        $currentTime = now();
        $fiveMinutesAgo = $currentTime->subMinutes(5)->format('Y-m-d H:i:s');
        $affected = DB::table('appointments')
            ->where('status', 'pending')
            ->whereRaw('CONCAT(appointment_date, " ", appointment_time) < ?', [$fiveMinutesAgo])
            ->update(['status' => 'expired']);

        Log::info("Checked appointments at {$currentTime}, updated {$affected} rows, threshold: {$fiveMinutesAgo}");

        $this->info("Checked appointments at {$currentTime}, updated {$affected} rows.");
        return 0;
    }
}