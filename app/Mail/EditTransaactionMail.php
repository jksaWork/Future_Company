<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EditTransaactionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $old_amount, $new_amount,  $type, $id;
    public function __construct($old_amount, $new_amount,  $type, $id = 1)
    {
        $this->type = $type;
        $this->id = $id;
        $this->old_amount = $old_amount;
        $this->new_amount = $new_amount;
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
            subject: 'تعديل في مبلغ تحويله',
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
                'type_message' => $this->type == 'credit' ? " تعديل عمليه ايداع " : ' تعديل عمليه سحب ',
                'amount_message' => $this->type != 'credit' ? "تم تعديل عمليه السحب من المبلغ " .  $this->old_amount .  " الي المبلغ" . $this->new_amount :
                    "تم تعديل عمليه الايداع من المبلغ " .  $this->old_amount .  " الي المبلغ" . $this->new_amount,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}