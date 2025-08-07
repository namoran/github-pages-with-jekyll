document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('esa-estimator-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const resultDiv = document.getElementById('esa-estimator-result');
            const submitButton = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);

            // Append action to form data
            formData.append('action', 'esa_estimator_get_estimate');

            // Display loading message and disable button
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = 'Calculating...';
            submitButton.disabled = true;

            fetch(esa_estimator_ajax.ajax_url, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = data.data.message;
                } else {
                    resultDiv.innerHTML = data.data.message;
                }
                submitButton.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = 'An error occurred. Please try again.';
                submitButton.disabled = false;
            });
        });
    }
});
