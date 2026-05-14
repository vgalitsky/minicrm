<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Ticket</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100dvh;
            padding: 20px;
            display: grid;
            place-items: center;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 14px;
            background: #fff;
            color: #111827;
        }

        h2 {
            margin: 0 0 20px;
            font-size: 17px;
            font-weight: 600;
            color: #111827;
        }

        form {
            width: min(480px, 100%);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        input, textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #111827;
            background: #fff;
            transition: border-color .15s, box-shadow .15s;
            outline: none;

            &::placeholder { color: #9ca3af; }
            &:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgb(37 99 235 / .12);
            }
        }

        textarea { resize: vertical; min-height: 100px; }

        button {
            padding: 10px 20px;
            background: #2563eb;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s;
            align-self: flex-start;

            &:hover { background: #1d4ed8; }
            &:active { background: #1e40af; }
        }

        .message {
            font-size: 13px;
            min-height: 18px;
            padding: 8px 12px;
            border-radius: 6px;
            display: none;

            &.visible { display: block; }
            &.error   { background: #fef2f2; color: #b91c1c; }
            &.success { background: #f0fdf4; color: #15803d; }
        }
    </style>
</head>
<body>
    <form id="minicrm-form" action="{{ route('minicrm.api.v1.tickets.create') }}" method="POST">
        @csrf
        <h2>Create Ticket</h2>

        <label>Name <input name="name" placeholder="Your name" required></label>
        <label>Phone <input name="phone" type="tel" placeholder="+1 234 567 8900" pattern="^\+?[0-9\s\-\(\)]{7,32}$" title="Phone number must be between 7 and 15 digits. Allow digits, spaces, dashes, parentheses, and an optional leading +."></label>
        <label>Email <input name="email" type="email" placeholder="you@example.com"></label>
        <label>Subject <input name="subject" placeholder="What is this about?" required></label>
        <label>Message <textarea name="description" placeholder="Describe your issue…" rows="5" required></textarea></label>

        <button type="submit">Submit</button>

        <div id="minicrm-message" class="message" role="alert"></div>
    </form>

    <script>
        document.getElementById('minicrm-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const form = event.target;
            const message = document.getElementById('minicrm-message');

            message.className = 'message';
            message.className = 'message';
            message.textContent = '';

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });

                const result = await response.json();

                if (!response.ok) {
                    message.classList.add('error', 'visible');
                    message.textContent = result.message || 'Validation error.';
                    return;
                }

                form.reset();

                message.classList.add('success', 'visible');
                message.textContent = result.message;
            } catch (error) {
                message.classList.add('error', 'visible');
                message.textContent = 'Request failed.';
            }
        });
    </script>
</body>
</html>