<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DailyOrdersReport extends Mailable
{
    use Queueable, SerializesModels;
    public $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Orders Report - ' . Carbon::now()->format('Y-m-d'),
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_orders_report'
        );
    }
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/reports/' . $this->filename))->as('daily_orders_report.xlsx')
        ];
    }
}
