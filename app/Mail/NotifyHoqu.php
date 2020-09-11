<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notifyHoqu extends Mailable
{
    use Queueable, SerializesModels;

    public $itemHoqu;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
         $this->itemHoqu = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@webmapp.it')->subject('Error Hoqu')->view('mail.notifyErrorHoqu',['mail_data'=>$this->itemHoqu]);
    }
}
