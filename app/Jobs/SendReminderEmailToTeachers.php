<?php

namespace App\Jobs;

use App\Mail\ReminderEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmailToTeachers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $teachers = User::where('type', 'teacher')
            ->whereNull('completed_at')
            ->get();

        foreach ($teachers as $teacher) {
            try {
                Mail::to($teacher->email)->queue(new ReminderEmail($teacher));
                Log::info("Reminder email sent to: " . $teacher->email);
            } catch (\Exception $e) {
                Log::error("Failed to send reminder email to {$teacher->email}: " . $e->getMessage());
            }
        }
    }
}
