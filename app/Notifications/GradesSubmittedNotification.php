<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GradesSubmittedNotification extends Notification
{
    protected $subject;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + database notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Grades Submitted')
                    ->line("Grades for {$this->subject->name} have been submitted by the teacher.")
                    ->action('View Grades', url('/department/grades/'.$this->subject->id));
    }

    public function toArray($notifiable)
    {
        return [
            'subject_id' => $this->subject->id,
            'message' => "Grades for {$this->subject->name} have been submitted."
        ];
    }
}
