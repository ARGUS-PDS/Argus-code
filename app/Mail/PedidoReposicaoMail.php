<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoReposicaoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fornecedor;
    public $produto;
    public $quantidade;
    public $prazo;
    public $emailContato;

    public function __construct($fornecedor, $produto, $quantidade, $prazo, $emailContato)
    {
        $this->fornecedor = $fornecedor;
        $this->produto = $produto;
        $this->quantidade = $quantidade;
        $this->prazo = $prazo;
        $this->emailContato = $emailContato;
    }

    public function build()
    {
        return $this->subject("Pedido de Reposição - {$this->produto->description}")
            ->markdown('emails.pedido-reposicao');
    }
}