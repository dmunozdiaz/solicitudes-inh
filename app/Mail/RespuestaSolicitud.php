<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespuestaSolicitud extends Mailable {

    use Queueable,
        SerializesModels;

    public $details;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details) {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Respuesta a Solicitud Ciudadana, Municipalidad de Temuco')->view('email.respuestasolicitud',$this->details );
    }

}
