<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewItemMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;

    /**
     * Create a new message instance.
     *
     * @pram Seller $seller
     * @return void
     */
    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank you for selling with Junk or Treasures')
                    ->view('emails.newItemMail');
    }
}
