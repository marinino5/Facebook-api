<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Comment $comment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo comentario en tu publicación',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.comments.new',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
