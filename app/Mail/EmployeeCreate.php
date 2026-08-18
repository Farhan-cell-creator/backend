<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Employee Created',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-create',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}