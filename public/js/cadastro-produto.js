  function show() {
    const checkbox = document.querySelector('input[type="checkbox"]');
    const statusElement = document.getElementById("active");

    if (checkbox.checked) {
      statusElement.textContent = "Ativo";
    } else {
      statusElement.textContent = "Inativo";
    }
  }

  function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById("preview");
    const placeholder = document.getElementById("placeholder");

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove("hidden");
        placeholder.classList.add("hidden");
      };
      reader.readAsDataURL(file);
    }
  }