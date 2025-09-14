@component('mail::message')
# Pedido de Recuperação de Acesso

Um usuário informou que sua senha está vencida.

**E-mail:** {{ $dados['email'] }}  
**Cartão de Segurança (últimos 4 dígitos):** {{ $dados['cartao_seg'] }}

Verifique internamente e realize o procedimento manual.

@endcomponent
