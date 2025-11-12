<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Test extends Model
{
    protected $fillable = [
        'title',
        'subject_id',
        'teacher_id',
        'start_time',
        'scheduled_at',
        'has_pdf',
        'pdf_path',
        'pdf_original_name',
        'total_marks',
        'question_type'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'scheduled_at' => 'datetime',
        'has_pdf' => 'boolean',
    ];

    /**
     * RELATIONSHIPS
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function assignedTests()
    {
        return $this->hasMany(AssignedTest::class);
    }

    public function testAnswers()
    {
        return $this->hasMany(TestAnswer::class);
    }

    /**
     * CORRECTED TIME CHECKING METHODS
     */

    public function isUpcoming()
    {
        if (!$this->start_time) {
            // If no start time, check if deadline hasn't passed
            return $this->scheduled_at && now()->lessThan($this->scheduled_at);
        }

        return now()->lessThan($this->start_time);
    }

    public function isExpired()
    {
        if (!$this->scheduled_at) {
            return false; // No deadline set, never expires
        }

        return now()->greaterThan($this->scheduled_at);
    }

    public function isActive()
    {
        // If expired, not active
        if ($this->isExpired()) {
            return false;
        }

        // If upcoming, not active
        if ($this->isUpcoming()) {
            return false;
        }

        // If we have start time, check if we're past it
        if ($this->start_time) {
            return now()->greaterThanOrEqualTo($this->start_time);
        }

        // No start time means active immediately (until deadline)
        return true;
    }

    /**
     * STATUS ATTRIBUTE - CORRECTED ORDER
     */
    public function getStatusAttribute()
    {
        if ($this->isExpired()) return 'expired';
        if ($this->isUpcoming()) return 'upcoming';
        if ($this->isActive()) return 'active';
        return 'unknown';
    }

    /**
     * ENHANCED STATUS INFORMATION
     */
    public function getDetailedStatus()
    {
        $now = now();

        $statusInfo = [
            'test_id' => $this->id,
            'title' => $this->title,
            'current_time' => $now->format('Y-m-d H:i:s'),
            'start_time' => $this->start_time ? $this->start_time->format('Y-m-d H:i:s') : null,
            'scheduled_at' => $this->scheduled_at ? $this->scheduled_at->format('Y-m-d H:i:s') : null,
            'is_upcoming' => $this->isUpcoming(),
            'is_expired' => $this->isExpired(),
            'is_active' => $this->isActive(),
            'status' => $this->status,
        ];

        // Add human-readable time differences
        if ($this->start_time) {
            if ($now->lessThan($this->start_time)) {
                $statusInfo['time_until_start'] = $now->diffForHumans($this->start_time, ['syntax' => Carbon::DIFF_ABSOLUTE]);
            } else {
                $statusInfo['time_since_start'] = $now->diffForHumans($this->start_time, ['syntax' => Carbon::DIFF_ABSOLUTE]);
            }
        }

        if ($this->scheduled_at) {
            if ($now->lessThan($this->scheduled_at)) {
                $statusInfo['time_until_deadline'] = $now->diffForHumans($this->scheduled_at, ['syntax' => Carbon::DIFF_ABSOLUTE]);
            } else {
                $statusInfo['time_since_deadline'] = $now->diffForHumans($this->scheduled_at, ['syntax' => Carbon::DIFF_ABSOLUTE]);
            }
        }

        return $statusInfo;
    }

    /**
     * TIME VALIDATION METHODS FOR CONTROLLERS
     */

    /**
     * Check if test can be viewed by students
     */
    public function canBeViewed()
    {
        return $this->isActive() || $this->isUpcoming();
    }

    /**
     * Check if test can be submitted by students
     */
    public function canBeSubmitted()
    {
        return $this->isActive();
    }

    /**
     * Get time remaining until deadline (for countdowns)
     */
    public function getTimeRemaining()
    {
        if (!$this->scheduled_at || $this->isExpired()) {
            return null;
        }

        $now = now();

        return [
            'total_seconds' => $now->diffInSeconds($this->scheduled_at, false),
            'hours' => floor($now->diffInSeconds($this->scheduled_at, false) / 3600),
            'minutes' => floor(($now->diffInSeconds($this->scheduled_at, false) % 3600) / 60),
            'seconds' => $now->diffInSeconds($this->scheduled_at, false) % 60,
            'formatted' => $this->formatTimeRemaining($now->diffInSeconds($this->scheduled_at, false))
        ];
    }

    /**
     * Get time until start (for countdowns)
     */
    public function getTimeUntilStart()
    {
        if (!$this->start_time || !$this->isUpcoming()) {
            return null;
        }

        $now = now();

        return [
            'total_seconds' => $now->diffInSeconds($this->start_time, false),
            'hours' => floor($now->diffInSeconds($this->start_time, false) / 3600),
            'minutes' => floor(($now->diffInSeconds($this->start_time, false) % 3600) / 60),
            'seconds' => $now->diffInSeconds($this->start_time, false) % 60,
            'formatted' => $this->formatTimeRemaining($now->diffInSeconds($this->start_time, false))
        ];
    }

    /**
     * Format time remaining for display
     */
    private function formatTimeRemaining($seconds)
    {
        if ($seconds <= 0) {
            return '00:00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * DEBUGGING METHODS
     */

    /**
     * Debug timing information for troubleshooting
     */
    public function debugTiming()
    {
        $now = now();

        return [
            'test_info' => [
                'id' => $this->id,
                'title' => $this->title,
                'has_start_time' => !is_null($this->start_time),
                'has_scheduled_at' => !is_null($this->scheduled_at),
            ],
            'timezone_info' => [
                'app_timezone' => config('app.timezone'),
                'php_timezone' => date_default_timezone_get(),
            ],
            'current_times' => [
                'server_time' => now()->format('Y-m-d H:i:s'),
                'database_start_raw' => $this->getRawOriginal('start_time'),
                'database_scheduled_raw' => $this->getRawOriginal('scheduled_at'),
            ],
            'times' => [
                'start_time' => $this->start_time ? $this->start_time->format('Y-m-d H:i:s') : null,
                'scheduled_at' => $this->scheduled_at ? $this->scheduled_at->format('Y-m-d H:i:s') : null,
            ],
            'status_checks' => [
                'is_upcoming' => $this->isUpcoming(),
                'is_expired' => $this->isExpired(),
                'is_active' => $this->isActive(),
                'status' => $this->status,
            ],
            'time_differences' => [
                'until_start_minutes' => $this->start_time ? $now->diffInMinutes($this->start_time, false) : null,
                'until_deadline_minutes' => $this->scheduled_at ? $now->diffInMinutes($this->scheduled_at, false) : null,
            ]
        ];
    }

    /**
     * SCOPES FOR QUERYING TESTS BY STATUS
     */

    public function scopeUpcoming($query)
    {
        return $query->where(function($q) {
            $q->whereNotNull('start_time')
              ->where('start_time', '>', now());
        });
    }

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            // Tests with both start_time and scheduled_at
            $q->where(function($q2) {
                $q2->whereNotNull('start_time')
                   ->where('start_time', '<=', now())
                   ->whereNotNull('scheduled_at')
                   ->where('scheduled_at', '>=', now());
            })
            // Tests with only scheduled_at (no start time restriction)
            ->orWhere(function($q2) {
                $q2->whereNull('start_time')
                   ->whereNotNull('scheduled_at')
                   ->where('scheduled_at', '>=', now());
            })
            // Tests with only start_time (no deadline)
            ->orWhere(function($q2) {
                $q2->whereNotNull('start_time')
                   ->where('start_time', '<=', now())
                   ->whereNull('scheduled_at');
            });
        });
    }

    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNotNull('scheduled_at')
              ->where('scheduled_at', '<', now());
        });
    }

    /**
     * UTILITY METHODS
     */

    /**
     * Check if student has submitted this test
     */
    public function hasStudentSubmission($studentId)
    {
        return $this->testAnswers()
            ->where('student_id', $studentId)
            ->exists();
    }

    /**
     * Get student's submission for this test
     */
    public function getStudentSubmission($studentId)
    {
        return $this->testAnswers()
            ->where('student_id', $studentId)
            ->with('question')
            ->get();
    }

    /**
     * Get all submissions for this test
     */
    public function getAllSubmissions()
    {
        return $this->testAnswers()
            ->with(['student', 'question'])
            ->get()
            ->groupBy('student_id');
    }

    /**
     * Check if test has PDF questions
     */
    public function hasPdfQuestions()
    {
        return $this->has_pdf && $this->pdf_path;
    }

    /**
     * Get PDF question for this test
     */
    public function getPdfQuestion()
    {
        return $this->questions()
            ->where('type', 'written')
            ->first();
    }

    /**
     * Check if test is accessible right now
     */
    public function isAccessible()
    {
        return $this->isActive();
    }

    /**
     * Check if test submissions are allowed
     */
    public function allowsSubmissions()
    {
        return $this->isActive();
    }
}
