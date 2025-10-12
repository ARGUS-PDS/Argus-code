<?php

namespace App\Services;

use SendGrid;
use SendGrid\Mail\Mail;
use Exception;
use Illuminate\Support\Facades\Log;

class SendGridService
{
    protected SendGrid $client;

    public function __construct()
    {
        $apiKey = config('services.sendgrid.key', env('SENDGRID_API_KEY'));
        
        if (empty($apiKey)) {
            Log::error('SendGridService: API key não encontrada no .env ou config');
            throw new \Exception('Chave SendGrid ausente');
        }
        
        // Log para verificar se a chave está sendo carregada
        Log::info('SendGridService: Inicializando com API Key', [
            'api_key_start' => substr($apiKey, 0, 5) . '...',
            'api_key_length' => strlen($apiKey)
        ]);
        
        $this->client = new SendGrid($apiKey);
    }

    public function sendEmail(string $to, string $subject, string $view, array $data = []): bool
    {
        try {
            Log::info('SendGridService: Preparando e-mail', [
                'to' => $to,
                'subject' => $subject,
                'view' => $view,
                'data_keys' => array_keys($data) // Para debug das variáveis passadas
            ]);

            $email = new Mail();
            $email->setFrom(
                config('mail.from.address', 'argontechsolut@gmail.com'),
                config('mail.from.name', 'Argus')
            );
            $email->setSubject($subject);
            $email->addTo($to);
            
            // Verifica se a view existe
            if (!view()->exists($view)) {
                Log::error("SendGridService: View '$view' não encontrada!");
                throw new Exception("View '$view' não encontrada");
            }
            
            // Log das variáveis que serão passadas para a view
            Log::debug('SendGridService: Dados para a view', $data);
            
            // Renderiza a view com os dados
            $htmlContent = view($view, $data)->render();
            
            // Verifica se o conteúdo foi gerado corretamente
            if (empty($htmlContent)) {
                Log::error('SendGridService: Conteúdo HTML vazio após renderização da view');
                throw new Exception('Conteúdo do e-mail vazio');
            }
            
            $email->addContent('text/html', $htmlContent);

            Log::info('SendGridService: Enviando e-mail...');

            $response = $this->client->send($email);

            Log::info('SendGridService: Resposta', [
                'status_code' => $response->statusCode(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);

            // Verifica se o e-mail foi aceito para entrega
            $success = $response->statusCode() === 202;
            
            if ($success) {
                Log::info('SendGridService: E-mail enviado com sucesso');
            } else {
                Log::error('SendGridService: Falha no envio', [
                    'status_code' => $response->statusCode(),
                    'body' => $response->body()
                ]);
            }

            return $success;

        } catch (Exception $e) {
            Log::error('SendGridService: Erro: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Método específico para enviar e-mails de contato
     */
    public function sendContactEmail(array $contactData): bool
    {
        return $this->sendEmail(
            $contactData['to'] ?? config('mail.contact_to', 'gustavoemiliano2014@gmail.com'),
            $contactData['subject'] ?? 'Novo Contato - Site',
            'emails.contato',
            [
                'email' => $contactData['email'] ?? '',
                'nome' => $contactData['nome'] ?? '',
                'mensagem' => $contactData['mensagem'] ?? '',
                'telefone' => $contactData['telefone'] ?? '',
                'empresa' => $contactData['empresa'] ?? '',
                'assunto' => $contactData['assunto'] ?? '',
                // Inclui todos os dados adicionais
                ...$contactData
            ]
        );
    }
}