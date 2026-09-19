(function () {
    'use strict';

    var config = window.mysalaryForms || {};
    var forms = document.querySelectorAll('.mysalary-ajax-form');

    if (!forms.length || !config.ajaxUrl) return;

    function fieldWrapper(field) {
        return field ? field.closest('.form-field') : null;
    }

    function errorBox(field) {
        var wrapper = fieldWrapper(field);
        if (!wrapper) return null;
        var box = wrapper.querySelector('.field-error');
        if (!box) {
            box = document.createElement('div');
            box.className = 'field-error';
            wrapper.appendChild(box);
        }
        return box;
    }

    function clearError(field) {
        if (!field) return;
        field.classList.remove('error');
        field.removeAttribute('aria-invalid');
        var box = errorBox(field);
        if (box) box.textContent = '';
    }

    function setError(form, name, message) {
        var field = form.elements.namedItem(name);
        if (!field || !field.tagName) return;
        field.classList.add('error');
        field.setAttribute('aria-invalid', 'true');
        var box = errorBox(field);
        if (box) box.textContent = message;
    }

    function setStatus(status, message, isError) {
        if (!status) return;
        status.textContent = message || '';
        status.classList.toggle('is-error', Boolean(isError));
    }

    function validate(form) {
        var valid = true;
        var messages = config.i18n || {};

        Array.prototype.forEach.call(form.elements, function (field) {
            if (!field.name || field.type === 'hidden' || field.name === 'website') return;
            clearError(field);

            var empty = field.type === 'checkbox' ? !field.checked : !String(field.value || '').trim();
            if (field.required && empty) {
                setError(form, field.name, messages.required || 'This field is required.');
                valid = false;
                return;
            }

            if (!empty && field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                setError(form, field.name, messages.email || 'Enter a valid email.');
                valid = false;
            }

            if (!empty && field.type === 'url') {
                try {
                    new URL(field.value);
                } catch (error) {
                    setError(form, field.name, messages.url || 'Enter a valid URL.');
                    valid = false;
                }
            }

            if (field.type === 'file' && field.files && field.files[0]) {
                var file = field.files[0];
                var extension = file.name.split('.').pop().toLowerCase();
                if (['pdf', 'doc', 'docx'].indexOf(extension) === -1) {
                    setError(form, field.name, messages.fileType || 'Upload a PDF, DOC, or DOCX file.');
                    valid = false;
                } else if (file.size > 5 * 1024 * 1024) {
                    setError(form, field.name, messages.fileSize || 'The file must be 5 MB or smaller.');
                    valid = false;
                }
            }
        });

        if (!valid) {
            var first = form.querySelector('[aria-invalid="true"]');
            if (first) first.focus();
        }

        return valid;
    }

    Array.prototype.forEach.call(forms, function (form) {
        var button = form.querySelector('[type="submit"]');
        var status = form.querySelector('.form-status');
        var originalButtonHtml = button ? button.innerHTML : '';

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            setStatus(status, '', false);
            if (!validate(form) || !button) return;

            button.disabled = true;
            button.innerHTML = (config.i18n && config.i18n.sending) || 'Sending…';

            var data = new FormData(form);
            data.set('action', form.getAttribute('data-action') || data.get('action') || '');
            data.set('mysalary_nonce', config.nonce || data.get('mysalary_nonce') || '');
            data.set('lang', config.lang || data.get('lang') || '');

            fetch(config.ajaxUrl, {
                method: 'POST',
                body: data,
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (response) {
                    return response.json().catch(function () {
                        throw new Error((config.i18n && config.i18n.error) || 'Something went wrong. Please try again.');
                    });
                })
                .then(function (json) {
                    var payload = json.data || {};
                    if (!json.success) {
                        if (payload.errors) {
                            Object.keys(payload.errors).forEach(function (name) {
                                setError(form, name, payload.errors[name]);
                            });
                        }
                        throw new Error(payload.message || ((config.i18n && config.i18n.error) || 'Something went wrong. Please try again.'));
                    }

                    form.reset();
                    button.classList.add('success');
                    button.innerHTML = (config.i18n && config.i18n.success) || '✓ Sent';
                    setStatus(status, form.getAttribute('data-success') || payload.message || ((config.i18n && config.i18n.success) || 'Sent.'), false);

                    window.setTimeout(function () {
                        button.disabled = false;
                        button.classList.remove('success');
                        button.innerHTML = originalButtonHtml;
                    }, 3000);
                })
                .catch(function (error) {
                    button.disabled = false;
                    button.innerHTML = originalButtonHtml;
                    setStatus(status, error.message || ((config.i18n && config.i18n.error) || 'Something went wrong. Please try again.'), true);
                });
        });
    });
}());
