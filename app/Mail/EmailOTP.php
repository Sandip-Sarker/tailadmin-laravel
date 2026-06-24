<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailOTP extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;
    public $messageTitle;
    public $mailType;

    public function __construct(string $otp, $user, string $messageTitle,string $mailType) {
        $this->otp = $otp;
        $this->user = $user;
        $this->messageTitle = $messageTitle;
        $this->mailType = $mailType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->messageTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.otp',
        );
    }

}
