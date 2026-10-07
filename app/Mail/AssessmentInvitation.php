<?php

namespace App\Mail;

use App\Models\AssessmentAttendant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssessmentInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AssessmentAttendant $attendant)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your assessment is ready: ' . $this->attendant->assessment->title,
        );
    }

    public function content(): Content
    {
        $assessment = $this->attendant->assessment;

        return new Content(
            view: 'emails.assessment_invitation',
            with: [
                'attendant' => $this->attendant,
                'assessment' => $assessment,
                'link' => $assessment->publicUrl(),
            ],
        );
    }
}
