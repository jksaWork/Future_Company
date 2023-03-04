<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class withDrowalFromTuresy extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $amount, $type, $id;
    public function __construct($amount, $type, $id = 1)
    {
        $this->type = $type;
        $this->id = $id;
        $this->amount = $amount;
        // dd($type);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('jksa@mbh-tech.com', 'Future Conpmany'),
            subject: 'عمليات سحب او ايداع علي الخزينه المحليه',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mails.with_draw',
            with: [
                'amount' => 213,
                'url' => route('admin.finanical', ['id' => $this->id]),
                'type_message' => $this->type == 'credit' ? "عمليه ايداع جديده" : 'عمليه سحب جديده',
                'amount_message' => $this->type == 'debit' ?  "تم سحب " . $this->amount . " من الخزينه" :  "تم ايداع " . $this->amount . " الي الخزينه"
            ]
        );
    }

    /**
     * Get the atta chments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}