@if ($errors->any() || session('success') || session('error'))
<div class="modal fade show" id="alertModal" tabindex="-1" aria-modal="true" role="dialog" style="display:block; background: rgba(0,0,0,.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:#f8f0e5; color:#773138;">

      {{-- Cabeçalho --}}
      <div class="modal-header" style="background-color:#773138; color:#f8f0e5;">
        <h5 class="modal-title" style="color: #ffffff;">
          @if ($errors->any() || session('error'))
            Erro
          @elseif (session('success'))
            Sucesso
          @endif
        </h5>
        <button type="button" class="btn-close btn-close-white" onclick="closeAlertModal()"></button>
      </div>

      {{-- Corpo --}}
      <div class="modal-body">
        @if ($errors->any())
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li style="color:red;">{{ $error }}</li>
            @endforeach
          </ul>
        @endif

        @if (session('success'))
          <p class="mb-0">{{ session('success') }}</p>
        @endif

        @if (session('error'))
          <p class="mb-0" style="color:red;">{{ session('error') }}</p>
        @endif
      </div>

      {{-- Rodapé --}}
      <div class="modal-footer">
        <button type="button" class="btn custom-btn" onclick="closeAlertModal()">Fechar</button>
      </div>

    </div>
  </div>
</div>

<style>
  .custom-btn {
    background-color: #773138;
    color: #f8f0e5;
    border: none;
  }
  .custom-btn:hover {
    background-color: #77313880;
    color: #f8f0e5;
  }
</style>

<script>
  function closeAlertModal() {
    document.getElementById("alertModal").style.display = "none";
    document.querySelector("#alertModal").classList.remove("show");
  }
</script>
@endif
