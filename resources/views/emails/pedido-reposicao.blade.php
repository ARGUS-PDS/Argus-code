@component('mail::message')
# Pedido de Reposição

Olá, **{{ $fornecedor->name }}**!

Estamos solicitando **{{ $quantidade }} unidades** do produto **"{{ $produto->description }}"**.

📦 **Prazo de entrega sugerido**: {{ $prazo }}

---

📬 Em caso de dúvidas, entre em contato com o responsável pelo pedido:  
**{{ $emailContato }}**

Obrigado,<br>
<img src="https://i.imgur.com/zPNz2fY.jpeg/150x40?text=AlertaEstoque" alt="Logo">
@endcomponent
