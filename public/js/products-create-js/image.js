function previewImage(event) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    const removeBtn = document.getElementById('removeBtn');
    const removeImageInput = document.getElementById('remove_image');

    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
            if (removeBtn) removeBtn.style.display = 'block';
            if (removeImageInput) removeImageInput.value = '0';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
}


function removeImage() {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    const removeBtn = document.getElementById('removeBtn');
    const imageInput = document.getElementById('image_url');
    const removeImageInput = document.getElementById('remove_image');

    preview.src = '#';
    preview.classList.add('d-none');
    if (placeholder) {
        placeholder.textContent = 'Nenhuma imagem selecionada';
        placeholder.classList.remove('d-none');
    }
    if (removeBtn) removeBtn.style.display = 'none';
    if (imageInput) imageInput.value = '';
    if (removeImageInput) removeImageInput.value = '1';
}

document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    const removeBtn = document.getElementById('removeBtn');
    const imageInput = document.getElementById('image_url');
    const removeImageInput = document.getElementById('remove_image');

    function updateRemoveButtonVisibility() {
        if (!removeBtn || !preview) return;
        const hasImage = preview.src && preview.src !== '#' && !preview.classList.contains('d-none');
        removeBtn.style.display = hasImage ? 'block' : 'none';
        placeholder.classList.toggle('d-none', hasImage);
    }

    imageInput.addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                updateRemoveButtonVisibility();
                removeImageInput.value = '0';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    removeBtn.addEventListener('click', function() {
        preview.src = '#';
        preview.classList.add('d-none');
        imageInput.value = '';
        removeImageInput.value = '1';
        updateRemoveButtonVisibility();
    });

    updateRemoveButtonVisibility();
});


document.getElementById('removeBtn').addEventListener('click', function() {
    const preview = document.getElementById('preview');
    const removeBtn = this;
    const placeholder = document.getElementById('placeholder');
    const validMsg = document.getElementById('validMessage');
    const removeInput = document.getElementById('remove_image');

    preview.src = '#';
    preview.classList.add('d-none');
    removeBtn.style.display = 'none';

    placeholder.style.display = 'block';

    if (validMsg) validMsg.style.display = 'none';

    if (removeInput) removeInput.value = 1;
});