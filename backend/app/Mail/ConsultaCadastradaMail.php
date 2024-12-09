<?php

namespace App\Mail;

use App\Models\Consulta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\PDF; // Importando o PDF

class ConsultaCadastradaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $consulta;
    public $profissional;

    /**
     * Create a new message instance.
     */
    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
        $this->profissional = $consulta->profissionalConsulta->profissional; // Pegando o profissional associado à consulta
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Gerar o PDF
        $pdf = PDF::loadView('pdf.comprovante_consulta', [
            'consulta' => $this->consulta,
            'profissional' => $this->profissional
        ]);

        return $this->subject('Sua consulta foi confirmada!')
                    ->view('emails.consulta_cadastrada')
                    ->attachData($pdf->output(), 'comprovante_consulta.pdf'); // Anexar o PDF
    }
}
