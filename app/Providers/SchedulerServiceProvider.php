<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;

class SchedulerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schedule::call(function () {
            $now = now();
            $appointments = \App\Models\Appointment::where('status', ['pending', 'scheduled'])->get();
            foreach ($appointments as $appointment) {
                $appointmentTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointment_date . ' ' . $appointment->appointment_time);
                if ($appointmentTime < $now) {
                    $appointment->update(['status' => 'expired']);
                    event(new \App\Events\AppointmentNotification($appointment));
                }
            }
        })->everyMinute();

        // Add notification for upcoming appointments
        Schedule::call(function () {
            $now = now();
            $appointments = \App\Models\Appointment::where('status', 'scheduled')->get();
            foreach ($appointments as $appointment) {
                $appointmentTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointment_date . ' ' . $appointment->appointment_time);
                if ($appointmentTime->diffInMinutes($now) <= 5 && $appointmentTime > $now) {
                    event(new \App\Events\AppointmentNotification($appointment));
                }
            }
        })->everyMinute();
    }
}