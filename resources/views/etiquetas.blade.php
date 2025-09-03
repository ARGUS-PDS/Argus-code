@extends('layouts.app')
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

.form-add-card {
    background-color: var(--color-vinho);
    border: 1px solid var(--color-vinho-fundo);
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    padding: 25px;
    margin-bottom: 25px;
}


.form-add-card .form-control {
    border-radius: 10px;
    border: 1px solid var(--color-bege-medio);
    padding: 10px 15px;
    flex-grow: 1;
}


.form-add-card .form-control:focus {
    border-color: var(--color-bege-claro);
    box-shadow: 0 0 0 0.25rem var(--color-bege-claro-fundo);
}


.form-add-card .btn-primary {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
    border-radius: 10px;
    padding: 10px 20px;
    border: 2px solid var(--color-bege-claro);
    transition: background-color 0.3s ease, transform 0.2s ease;
}


.form-add-card .btn-primary:hover {
    background-color: var(--color-bege-claro);
    transform: translateY(-2px);
    border: 2px solid var(--color-bege-claro);
    color: var(--color-vinho);
}


.form-add-card .col-form-label {
    color: var(--color-bege-claro);
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
    background-color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    color: var(--color-vinho);
    transition: all 0.3s ease;
    border-radius: 10px;
}


.action-buttons .btn-outline-danger:hover {
    background-color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    transform: translateY(-2px);
    color: var(--color-bege-claro);
}


.action-buttons .btn-success {
    background-color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    border-radius: 10px;
    transition: all 0.3s ease;
}


.action-buttons .btn-success:hover {
    background-color: var(--color-bege-claro);
    color: var(--color-bege-color);
    border: 2px solid var(--color-vinho);
    transform: translateY(-2px);
}


.etiquetas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 20px;
    padding: 20px 0;
    justify-content: center;
}


.etiqueta {
    background-color: var(--color-vinho);
    border: 1px solid var(--color-vinho-fundo);
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
    color: var(--color-bege-claro);
    margin-bottom: 10px;
    white-space: normal;
    overflow: visible;
    text-overflow: initial;
    display: block;
    -webkit-line-clamp: initial;
    -webkit-box-orient: vertical;
    line-clamp: initial;
    max-height: none;
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
    color: var(--color-bege-claro);
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
    body, html {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .container-card {
        display: block !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: none !important;
    }
    .header-section, .form-add-card, .action-buttons, .alert, .header, .nav, .footer {
        display: none !important;
    }
    .etiquetas-grid {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 15px !important;
        page-break-after: always !important;
        width: 100% !important;
    }
    .etiqueta {
        border: 1px solid #000 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        padding: 10px !important;
        page-break-inside: avoid !important;
        min-height: 120px !important;
        display: block !important;
        width: 100% !important;
    }
    .etiqueta h3, .etiqueta .preco, .etiqueta .barcode {
        color: #000 !important;
    }
    .etiqueta h3 {
        font-size: 0.9rem !important;
        margin-bottom: 5px !important;
        white-space: normal;
        overflow: visible;
        text-overflow: initial;
        display: block;
        -webkit-line-clamp: initial;
        line-clamp: initial;
        max-height: none;
    }
    .etiqueta .preco {
        font-size: 1.1rem !important;
    }
    .etiqueta .barcode img {
        height: 30px !important;
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
        <h2>{{ __('labels.titulo_etiquetas') }}</h2>
    </div>


    @if(session('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif


    <div class="form-add-card">
        <form method="POST" action="{{ route('etiquetas.adicionar') }}" class="d-flex align-items-center gap-3">
            @csrf
            <label for="codigo" class="col-form-label mb-0">{{ __('labels.codigo_barras_label') }}</label>
            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="{{ __('labels.placeholder_codigo') }}" required autofocus />
            <button type="submit" class="btn btn-primary">{{ __('labels.adicionar_btn') }}</button>
        </form>
    </div>


    @if(!empty($etiquetas))
        <div class="action-buttons">
            <a href="{{ route('etiquetas.limpar') }}" class="btn btn-outline-danger">{{ __('labels.limpar_tudo') }}</a>
            <button onclick="window.print()" class="btn btn-success">{{ __('labels.imprimir_etiquetas') }}</button>
        </div>


        <div class="etiquetas-grid">
            @foreach ($etiquetas as $et)
                <div class="etiqueta">
                    <h3 title="{{ $et['nome'] }}">{{ $et['nome'] }}</h3>
                    <div class="preco-barcode">
                        <div class="preco">R$ {{ number_format((float) $et['preco'], 2, ',', '.') }}</div>
                        <div class="barcode">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($et['codigo'], 'C128', 2, 60, [248, 240, 229], true) }}" 
                            alt="{{ __('labels.alt_codigo_barras') }} {{ $et['codigo'] }}" />
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