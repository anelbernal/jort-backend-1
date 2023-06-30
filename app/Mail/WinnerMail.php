<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $winner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($winner)
    {
        $this->winner = $winner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations! You won!')
                    ->view('emails.winnerMail');
    }
}
