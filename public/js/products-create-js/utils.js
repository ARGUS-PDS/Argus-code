document.addEventListener("DOMContentLoaded", function () {
    const fields = {
        description: value => value.trim().length > 0 && !/^\d+$/.test(value),
        barcode: value => {
            if (!/^\d{8,13}$/.test(value)) return false;

            if (/^(\d)\1+$/.test(value)) return false;

            return true;
        },
        code: value => value.trim().length > 0,
        value: value => parseFloat(value) > 0,
        brand: value => value.trim().length === 0 || !/^\d+$/.test(value),
        model: value => value.trim().length === 0 || !/^\d+$/.test(value),
        currentStock: value => value === "" || parseInt(value) >= 0,
        minimumStock: value => value === "" || parseInt(value) >= 0,
        image_url: value => {
            if (!value) return true;
            return /\.(jpg|jpeg|png|gif)$/i.test(value);
        }
    };

    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (!input) return;

        input.addEventListener("input", function () {
            const isValid = fields[fieldId](input.value);

            input.classList.remove("is-valid", "is-invalid");
            if (input.value.trim() !== "") {
                input.classList.add(isValid ? "is-valid" : "is-invalid");
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const camposEstoque = [
        {id: 'currentStock', maxDigits: 6},
        {id: 'minimumStock', maxDigits: 6}
    ];

    camposEstoque.forEach(campo => {
        const input = document.getElementById(campo.id);

        input.addEventListener('input', function() {
            if (this.value.length > campo.maxDigits) {
                this.value = this.value.slice(0, campo.maxDigits);
            }

            if (this.value === '' || isNaN(this.value) || Number(this.value) < 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});


const valueInput = document.querySelector('input[name="value"]');

valueInput.addEventListener('input', function() {
    if (parseFloat(this.value) > 999999.99) {
        this.value = '999999.99';
    }

    const parts = this.value.split('.');
    if (parts[0].length > 6) {
        parts[0] = parts[0].slice(0, 6);
        this.value = parts.join('.');
    }

    if (parts[1] && parts[1].length > 2) {
        parts[1] = parts[1].slice(0, 2);
        this.value = parts.join('.');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-salvar'); 
    const mandatoryAlert = document.getElementById('mandatoryAlert');

    const requiredFields = ['description', 'barcode', 'code'];

    function checkFormValidity() {
        let allFilled = true;
        requiredFields.forEach(id => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            mandatoryAlert.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            mandatoryAlert.style.display = 'none';
            submitBtn.disabled = false;
        }
    }

    checkFormValidity();
    requiredFields.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', checkFormValidity);
            el.addEventListener('change', checkFormValidity);
        }
    });

    form.addEventListener('submit', function(event) {
        checkFormValidity();
        if (submitBtn.disabled) {
            event.preventDefault();
        }
    });
});
