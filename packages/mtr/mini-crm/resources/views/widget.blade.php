<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 24px; }
        form { max-width: 480px; }
        input, textarea, button {
            width: 100%;
            margin-bottom: 12px;
            padding: 10px;
            box-sizing: border-box;
        }
        .message { margin-top: 12px; }
        .error { color: #b00020; }
        .success { color: #087f23; }
    </style>
</head>
<body>
    <form id="minicrm-form" action="{{ route('minicrm.api.v1.tickets.create') }}" method="POST">
        @csrf
        <h2>Create Ticket</h2>

        <input name="name" placeholder="Name" required>
        <input name="phone" type="tel" placeholder="Phone" pattern="^\+?[0-9\s\-\(\)]{7,32}$" title="Phone number must be between 7 and 15 digits. Allow digits, spaces, dashes, parentheses, and an optional leading +.">
        <input name="email" type="email" placeholder="Email">
        <input name="subject" placeholder="Subject" required>
        <textarea name="description" placeholder="Message" rows="5" required></textarea>

        <button type="submit">Create</button>

        <div id="minicrm-message" class="message"></div>
    </form>

    <script>
        document.getElementById('minicrm-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const form = event.target;
            const message = document.getElementById('minicrm-message');

            message.className = 'message';
            message.textContent = 'Processing...';

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'Accept': 'application/json',
                        //'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: new FormData(form),
                });

                const result = await response.json();

                if (!response.ok) {
                    message.classList.add('error');
                    message.textContent = result.message || 'Validation error.';
                    return;
                }

                form.reset();


                message.classList.remove('error');
                message.classList.add('success');
                message.textContent = result.message;
            } catch (error) {
                message.classList.add('error');
                message.textContent = 'Request failed.';
            }
        });
    </script>
</body>
</html>