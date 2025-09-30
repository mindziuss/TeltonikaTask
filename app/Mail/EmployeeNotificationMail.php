<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EmployeeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Employee $employee;
    public $defaultEmail;
    public $defaultName;

    /**
     * Create a new message instance.
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
        $this->defaultEmail = config('mail.default_mail');
        $this->defaultName = config('mail.default_name');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this?->employee?->company?->email ?? $this->defaultEmail, 
                $this?->employee?->company?->name ?? $this->defaultName),
            subject: 'Welcome to ' . $this?->employee?->company?->name ?? $this->defaultName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-notification',
            with: [
                'employee' => $this->employee,
                'defaultCompanyName' => $this->defaultName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
