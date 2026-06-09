<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public FormSubmission $submission) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Application Submission',
            to: 'info@janguinternational.org',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: <<<'HTML'
                <div style="font-family: system-ui, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background: linear-gradient(135deg, #059669, #10b981); padding: 32px; text-align: center; border-radius: 12px 12px 0 0;">
                        <h1 style="color: white; margin: 0; font-size: 24px;">New Application Received</h1>
                    </div>
                    <div style="padding: 24px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 12px 12px;">
                        <p style="color: #374151; font-size: 16px;">A new application has been submitted.</p>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
                            <tr><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Name</td><td style="padding: 8px 12px;">{{ $submission->first_name }}</td></tr>
                            <tr style="background: #f9fafb;"><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Email</td><td style="padding: 8px 12px;">{{ $submission->email }}</td></tr>
                            <tr><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Submitted</td><td style="padding: 8px 12px;">{{ $submission->created_at->format('d M Y, H:i') }}</td></tr>
                            <tr style="background: #f9fafb;"><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Phone</td><td style="padding: 8px 12px;">{{ $submission->data['phone'] ?? '—' }}</td></tr>
                            <tr><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Gender</td><td style="padding: 8px 12px;">{{ $submission->data['gender'] ?? '—' }}</td></tr>
                            <tr style="background: #f9fafb;"><td style="padding: 8px 12px; font-weight: 600; color: #6b7280;">Education</td><td style="padding: 8px 12px;">{{ $submission->data['education_level'] ?? '—' }}</td></tr>
                        </table>
                        <div style="margin-top: 24px; text-align: center;">
                            <a href="{{ url('/responses') }}" style="display: inline-block; background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600;">View in Dashboard</a>
                        </div>
                    </div>
                </div>
            HTML,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
