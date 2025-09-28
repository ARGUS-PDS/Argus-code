@include('layouts.css-variables')

        <div id="tela-carregando" style="
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            justify-content: center;
            align-items: center;
        ">
            <div style="color: white; font-size: 1.2rem; text-align: center;">
                <div class="loader" style="
                    border: 8px solid var(--bs-alert-bg-danger);
                    border-top: 8px solid #773138;
                    border-radius: 50%;
                    width: 60px;
                    height: 60px;
                    animation: spin 1s linear infinite;
                    margin: auto;
                "></div>
                <p style="margin-top: 10px;">{{ __('warning.processing') }}
</p>
            </div>
        </div>

        <style>            
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            
        }
        </style>

        <script>            
    function mostrarTelaCarregando() {
        document.getElementById('tela-carregando').style.display = 'flex';
    }

     function esconderTelaCarregando() {
        document.getElementById('tela-carregando').style.display = 'none';
    }
    </script>