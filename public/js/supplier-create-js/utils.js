document.addEventListener("DOMContentLoaded", function () {
    const fields = {
        description: value => value.trim().length > 0 && !/^\d+$/.test(value),
        barcode: value => /^\d{8,13}$/.test(value),
        code: value => value.trim().length > 0,
        value: value => value.trim() !== "" && !isNaN(parseFloat(value)) && parseFloat(value) >= 0,
        brand: value => value.trim() === "" || !/^\d+$/.test(value),
        model: value => value.trim() === "" || !/^\d+$/.test(value),
        currentStock: value => value === "" || (/^\d{1,6}$/.test(value) && Number(value) >= 0),
        minimumStock: value => value === "" || (/^\d{1,6}$/.test(value) && Number(value) >= 0),
        image_url: value => {
            if (!value) return true;
            return /\.(jpg|jpeg|png|gif)$/i.test(value);
        },
        supplierId: value => value !== "" && value !== null && value !== undefined,
        trade_name: value => {
            const val = value.trim();
            if (val.length === 0 || val.length > 100) return false;
            return !/^\d+$/.test(val); 
        },
        distributor: value => {
            const val = value.trim();
            if (val.length === 0 || val.length > 100) return false;
            return !/^\d+$/.test(val); 
        },
        street: value => {
        const val = value.trim();
        return val.length > 0 && val.length <= 120 && !/^\d+$/.test(val);
        },
        documento: value => /^(\d{11}|\d{14})$/.test(value.replace(/\D/g,'')),
        cep: value => /^\d{8}$/.test(value.replace(/\D/g,'')),
        place: value => value.trim().length > 0 && value.trim().length <= 100,
        number: value => value === "" || /^\d{1,6}$/.test(value),
        neighborhood: value => {
        const val = value.trim();
        return val.length > 0 && val.length <= 60 && !/^\d+$/.test(val);
        },
        city: value => /^[A-Za-zÀ-ÿ\s]{1,60}$/.test(value),
        state: value => value.trim().length > 0,
        phone: value => value.trim() === "" || /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value),
        email: value => {
            const val = value.trim();
            if (val === "") return false;

            const regex = /^[^\s@]+@[a-zA-Z0-9-]{2,}(\.[a-zA-Z]{2,})+$/;
            return regex.test(val);
        },
        contactName1: value => value.trim() === "" || /^[A-Za-zÀ-ÿ\s]{1,60}$/.test(value),
        contactPosition1: value => value.trim() === "" || /^[A-Za-zÀ-ÿ\s]{1,60}$/.test(value),
        contactNumber1: value => value.trim() === "" || /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value),
        contactName2: value => value.trim() === "" || /^[A-Za-zÀ-ÿ\s]{1,60}$/.test(value),
        contactPosition2: value => value.trim() === "" || /^[A-Za-zÀ-ÿ\s]{1,60}$/.test(value),
        contactNumber2: value => value.trim() === "" || /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value)
    };

    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (!input) return;

        const eventType = input.tagName.toLowerCase() === 'select' ? 'change' : 'input';

        input.addEventListener(eventType, function () {
            const raw = input.value || "";
            const isValid = fields[fieldId](raw);

            input.classList.remove("is-valid", "is-invalid");
            const isRequired = input.hasAttribute('required');
            if (raw.trim() === "" && !isRequired) {
            } else {
                input.classList.add(isValid ? "is-valid" : "is-invalid");
            }
        });
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const personType = document.getElementById("type");
    const cpfCnpj = document.getElementById("cpf_cnpj");

    cpfCnpj.disabled = true;

    function validateCpfCnpj() {
        const type = personType.value;
        const val = cpfCnpj.value.replace(/\D/g, '');

        let isValid = false;

        if (type === "FISICA") { 
            isValid = /^\d{11}$/.test(val);
        } else if (type === "JURIDICA") { 
            isValid = /^\d{14}$/.test(val);
        }

        cpfCnpj.classList.remove("is-valid", "is-invalid");
        if (val !== "") {
            cpfCnpj.classList.add(isValid ? "is-valid" : "is-invalid");
        }
    }

    personType.addEventListener("change", function() {
        if (personType.value === "FISICA" || personType.value === "JURIDICA") {
            cpfCnpj.disabled = false;
            cpfCnpj.value = ""; 
        } else {
            cpfCnpj.disabled = true;
            cpfCnpj.value = "";
        }
        validateCpfCnpj();
    });

    cpfCnpj.addEventListener("input", validateCpfCnpj);
});

document.addEventListener("DOMContentLoaded", function () {
    const cep = document.getElementById("zip_code");
    const addressFields = ["place","number","neighborhood","city","state"];
    const contact1Fields = ["contactName1","contactPosition1","contactNumber1"];
    const contact2Fields = ["contactName2","contactPosition2","contactNumber2"];
    const email = document.getElementById("email");
    const phone1 = document.getElementById("phone");
    const phone2 = document.getElementById("contactNumber2");

    addressFields.forEach(id => document.getElementById(id).disabled = true);
    contact1Fields.forEach(id => document.getElementById(id).disabled = true);
    contact2Fields.forEach(id => document.getElementById(id).disabled = true);


    function toggleAddressFields() {
        const val = cep.value.replace(/\D/g,'');
        const isValidCep = /^\d{8}$/.test(val);
        addressFields.forEach(id => document.getElementById(id).disabled = !isValidCep);
    }

    cep.addEventListener("input", toggleAddressFields);
    cep.addEventListener("blur", toggleAddressFields);

    function isValidPhone(value) {
        return /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(value);
    }

    function isValidEmail(value) {
        const regex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
        return regex.test(value);
    }

    function toggleContactFields() {
        const phoneValid = isValidPhone(phone1.value.trim());
        const emailValid = isValidEmail(email.value.trim());
        const enableContacts = phoneValid && emailValid;

        contact1Fields.forEach(id => document.getElementById(id).disabled = !enableContacts);
        contact2Fields.forEach(id => document.getElementById(id).disabled = !enableContacts);
    }

    email.addEventListener("input", toggleContactFields);
    phone1.addEventListener("input", toggleContactFields);
    phone2.addEventListener("input", toggleContactFields);
});

