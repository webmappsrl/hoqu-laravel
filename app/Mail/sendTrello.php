<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendTrello extends Mailable
{
    use Queueable, SerializesModels;

    public $hoquErrorTrello;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->hoquErrorTrello = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dd($this->hoquErrorTrello['error']['id']);
        return $this->from('noreply@webmapp.it')->subject('HOQU['.$this->hoquErrorTrello['error']['id'].']('.$this->hoquErrorTrello['error']['instance'].') '.'#bug')->view('mail.trello',['mail_data'=>$this->hoquErrorTrello]);
    }
}
