@component('mail::message')
# Novo Interesse no {{ $plano }}

Olá, **Equipe Argus**!

Um potencial cliente demonstrou interesse em nosso **{{ $plano }}** através do formulário de contato do site.

## 👤 Dados do Representante
**Nome:** {{ $nome }}
**Empresa:** {{ $empresa }}
**Email:** {{ $email }}
**WhatsApp:** {{ $whatsapp }}

## 🎯 Plano de Interesse
<span style="color: #490006; font-weight: bold; font-size: 1.1em;">{{ $plano }}</span>

---

💡 **Sugestão:** Entre em contato dentro de 24h para melhor conversão.

Obrigado,<br>
<img src="https://i.imgur.com/zPNz2fY.jpeg/150x40?text=AlertaEstoque" alt="Logo" style="margin-top: 20px;">
@endcomponent