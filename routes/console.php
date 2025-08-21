<?php

use App\Console\Commands\UpdateExpiredAppointments;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateExpiredAppointments::class)->everyMinute();