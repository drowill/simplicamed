<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Consulta;

class ConsultaFinalizadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $consulta;
    public $profissional;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Consulta $consulta){
        $this->consulta = $consulta;
        $this->profissional = $consulta->profissionalConsulta->profissional;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consulta finalizada!',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('emails.consulta_finalizada')
                    ->subject('Consulta Finalizada')
                    ->with([
                        'titulo' => $this->consulta->title,
                        'profissional' => $this->profissional->name,
                        'tipo' => $this->profissional->tipo,
                        'horario' => $this->consulta->horario,
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
