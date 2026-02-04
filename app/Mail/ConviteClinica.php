<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConviteClinica extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $nome;
    public string $nome_clinica;
    public string $link_convite;
    public string $data_expiracao;

    public function __construct($nome, $nome_clinica, $link_convite, $data_expiracao)
    {
        $this->nome = $nome;
        $this->nome_clinica = $nome_clinica;
        $this->link_convite = $link_convite;
        $this->data_expiracao = $data_expiracao;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Convite para acessar a clínica ' . $this->nome_clinica,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ConviteClinica',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
