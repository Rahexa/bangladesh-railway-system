console.log('verify-code.js loaded');
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();
    console.log('Form submitted');
    let form = this;
    let errorDiv = document.querySelector('.error-message') || document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.innerHTML = '';

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            console.log('Redirecting to:', data.redirect);
            window.location.href = data.redirect;
        } else {
            console.log('Error received:', data.error);
            errorDiv.innerHTML = data.error || 'An error occurred.';
            form.prepend(errorDiv);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        errorDiv.innerHTML = 'An error occurred. Please try again.';
        form.prepend(errorDiv);
    });
});