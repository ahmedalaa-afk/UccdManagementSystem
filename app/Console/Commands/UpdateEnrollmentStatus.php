<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateEnrollmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enrollment:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update enrollment status for students at the start of academic year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentMonth = Carbon::now()->month;

        // Only run in September (month 9)
        if ($currentMonth !== 9) {
            return;
        }

        // Get all students
        $students = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->get();

        foreach ($students as $student) {
            // Skip if student is in fourth year
            if ($student->current_year == 4) {
                continue;
            }

            // Update enrollment status to 'no'
            $student->is_enrolled = 'no';
            $student->save();

            $this->info("Updated enrollment status for student: {$student->name}");
        }

        $this->info('Enrollment status update completed successfully.');
    }
}
