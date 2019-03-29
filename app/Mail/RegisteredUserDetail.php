<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredUserDetail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The variables.
     *
     * @var var
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
         $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->to($this->data->toEmail, $this->data->toName, $this->data->toPassword)
                ->from(env('MAIL_USERNAME'), 'ProjectAdmin')
                ->subject($this->data->subject)
                ->view($this->data->templateId);
        return $template;
    }
}
