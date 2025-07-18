@include('layouts.css-variables')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet" />

<style>
    .container-card {
        background-color: var(--color-bege-card-interno);
        border-radius: 18px;
        padding: 35px 40px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid var(--color-gray-claro);
        margin-top: 40px;
        margin-bottom: 80px;
        margin-left: auto;
        margin-right: auto;
        max-width: 960px;
        width: 95%;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--color-gray-claro);
        flex-wrap: wrap;
    }

    .header-section h2 {
        color: var(--color-vinho);
        font-weight: bold;
        font-size: 2.2rem;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .btn-voltar {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-voltar:hover {
        background-color: var(--bs-btn-hover-bg);
        transform: translateY(-2px);
        color: var(--color-bege-claro);
    }

    .form-add-card {
        background-color: var(--color-white);
        border: 1px solid var(--color-gray-claro);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 25px;
    }

    .form-add-card .form-control {
        border-radius: 10px;
        border: 1px solid var(--color-gray-medio);
        padding: 10px 15px;
        flex-grow: 1;
    }

    .form-add-card .form-control:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem var(--color-vinho-fundo-transparente);
    }

    .form-add-card .btn-primary {
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 10px;
        padding: 10px 20px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form-add-card .btn-primary:hover {
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-bg);
        transform: translateY(-2px);
    }

    .form-add-card .col-form-label {
        color: var(--color-vinho);
        font-weight: 600;
        white-space: nowrap;
        margin-right: 10px;
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: var(--color-bege-card-interno);
        color: var(--color-vinho-claro);
        border-color: var(--color-bege-claro);
    }

    .action-buttons {
        margin-top: 30px;
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start;
        gap: 15px;
    }

    .action-buttons .btn-outline-danger {
        color: var(--color-red);
        border-color: var(--color-red);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .action-buttons .btn-outline-danger:hover {
        background-color: var(--color-red);
        color: var(--color-white);
    }

    .action-buttons .btn-success {
        background-color: var(--color-green);
        border-color: var(--color-green);
        border-radius: 10px;
        color: var(--color-white);
        transition: all 0.3s ease;
    }

    .action-buttons .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .etiquetas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 20px;
        padding: 20px 0;
        justify-content: center;
    }

    .etiqueta {
        background-color: var(--color-white);
        border: 1px solid var(--color-gray-claro);
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        min-height: 150px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .etiqueta:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

.etiqueta h3 {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--color-vinho);
    margin-bottom: 10px;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical; 
    line-clamp: 2; 
    max-height: 2.8em;
    line-height: 1.4em;
}

    .etiqueta .preco-barcode {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    .etiqueta .preco {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--color-gray-escuro);
        margin-bottom: 5px;
    }

    .etiqueta .barcode {
        width: 100%;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .etiqueta .barcode img {
        display: block;
        width: 90%;
        max-width: 150px;
        height: auto;
        object-fit: contain;
    }

    @media print {
        body {
            background-color: var(--color-white) !important;
            color: #000 !important;
        }
        .container-card, .header-section, .form-add-card, .action-buttons, .alert {
            display: none !important;
        }
        .etiquetas-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            page-break-after: always;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .etiqueta {
            border: 1px solid #000;
            border-radius: 0;
            box-shadow: none;
            padding: 10px;
            page-break-inside: avoid;
            min-height: 120px;
        }
        .etiqueta h3 {
            font-size: 0.9rem;
            margin-bottom: 5px;
            color: #000;
        }
        .etiqueta .preco {
            font-size: 1.1rem;
            color: #000;
        }
        .etiqueta .barcode img {
            height: 30px;
        }
    }

    @media (max-width: 768px) {
        .container-card {
            margin-top: 20px;
            margin-bottom: 50px;
            padding: 25px;
            width: calc(100% - 30px);
        }
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .header-section h2 {
            font-size: 1.8rem;
        }
        .form-add-card .d-flex {
            flex-direction: column;
            align-items: stretch !important;
            gap: 15px;
        }
        .form-add-card .col-form-label {
            margin-right: 0;
            margin-bottom: 5px;
        }
        .form-add-card .form-control {
            width: 100% !important;
        }
        .action-buttons {
            flex-direction: column;
            gap: 10px;
        }
        .etiquetas-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
        }
        .etiqueta {
            min-height: 130px;
            padding: 10px;
        }
        .etiqueta h3 {
            font-size: 0.95rem;
        }
        .etiqueta .preco {
            font-size: 1.1rem;
        }
        .etiqueta .barcode {
            height: 30px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-card">
    <div class="header-section">
        <h2>Gerar Etiquetas para Produtos</h2>
        <a href="{{ url()->previous() }}" class="btn-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-add-card">
        <form method="POST" action="{{ route('etiquetas.adicionar') }}" class="d-flex align-items-center gap-3">
            @csrf
            <label for="codigo" class="col-form-label mb-0">Código de Barras (GTIN):</label>
            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Digite ou escaneie o código" required autofocus />
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>

    @if(!empty($etiquetas))
        <div class="action-buttons">
            <a href="{{ route('etiquetas.limpar') }}" class="btn btn-outline-danger">Limpar Tudo</a>
            <button onclick="window.print()" class="btn btn-success">Imprimir Etiquetas</button>
        </div>

        <div class="etiquetas-grid">
            @foreach ($etiquetas as $et)
                <div class="etiqueta">
                    <h3 title="{{ $et['nome'] }}">{{ $et['nome'] }}</h3>
                    <div class="preco-barcode">
                        <div class="preco">R$ {{ number_format($et['preco'], 2, ',', '.') }}</div>
                        <div class="barcode">
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($et['codigo'], 'C128') }}" alt="Código de Barras: {{ $et['codigo'] }}" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
@endsection