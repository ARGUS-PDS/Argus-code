<div class="search-bar-component">
    <form action="{{ $action ?? url()->current() }}" method="GET" class="search-bar" autocomplete="off" style="margin-bottom:0;">
        <input class="search" type="text" name="{{ $name ?? 'q' }}" value="{{ $value ?? '' }}" placeholder="{{ $placeholder ?? 'Pesquisar...' }}" list="{{ $datalistId ?? 'produtos-list' }}">
        @if(isset($datalistOptions) && is_array($datalistOptions))
            <datalist id="{{ $datalistId ?? 'produtos-list' }}">
                @foreach($datalistOptions as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </datalist>
        @endif
        <button type="submit" style="background: none; border: none; padding: 0;">
            <i class="bi bi-search"></i>
        </button>
    </form>
    <style>
        .search-bar {
            background: transparent;
            border-radius: 20px;
            padding: 6px 16px;
            color: var(--color-vinho);
            width: 300px;
            display: flex;
            align-items: center;
            border: 2px solid var(--color-vinho);
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            width: 90%;
            color: var(--color-vinho);
        }

        .search-bar input::placeholder {
            color: var(--color-vinho);
            opacity: 1;
        }

        .search-bar:hover {
            background: var(--color-vinho);
            border-color: var(--color-vinho);
            color: var(--color-bege-claro);
        }

        .search-bar:hover input {
            color: var(--color-bege-claro);
        }
        
        .search-bar:hover input::placeholder {
            color: var(--color-bege-claro) !important;
            opacity: 1 !important;
        }
        .search-bar .bi-search {
            color: var(--color-vinho);
            font-size: 1.2rem;
            margin-left: 8px;
            border: none;
            transition: color 0.3s ease;
        }
        .search-bar:hover .bi-search {
            color: var(--color-bege-claro);
        }
    </style>
</div> 