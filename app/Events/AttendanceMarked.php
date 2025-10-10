<?php

namespace App\Events;

use App\Models\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceMarked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attendance;

    public function __construct(Attendance $attendance)
    {
          $this->attendance = $attendance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('attendance-channel');
    }

   public function broadcastAs(): string
    {
        // Event name that JS/Livewire will listen for
        return 'AttendanceMarked';
    }

    public function broadcastWith(): array
    {
        return [
            'student_name' => $this->attendance->student->first_name . ' ' . $this->attendance->student->last_name,
            'time' => $this->attendance->created_at->format('H:i:s'),
        ];
    }
}
