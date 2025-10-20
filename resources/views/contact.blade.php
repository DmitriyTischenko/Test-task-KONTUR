<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контактная форма</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        input.error-field {
            border-color: #e74c3c;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        button:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            color: #27ae60;
            font-size: 16px;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            background-color: #d5f4e6;
        }

        .notification {
            margin-top: 20px;
            padding: 12px;
            border-radius: 4px;
            text-align: center;
            font-weight: 500;
        }

        .notification.error {
            background-color: #fadbd8;
            color: #c0392b;
            border: 1px solid #e74c3c;
        }

        .notification.success {
            background-color: #d5f4e6;
            color: #27ae60;
            border: 1px solid #27ae60;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Контактная форма</h1>
    <form id="contactForm">
        @csrf
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" placeholder="Введите ваше имя" required>
            <div id="name-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" id="phone" name="phone" placeholder="+7 999 999 99 99" required>
            <div id="phone-error" class="error"></div>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
            <div id="email-error" class="error"></div>
        </div>
        <button type="submit" id="submitBtn">Отправить</button>
    </form>
    <div id="messageContainer"></div>
</div>

<script>
    function isValidPhone(phone) {
        const phoneRegex = /^\+7\s\d{3}\s\d{3}\s\d{2}\s\d{2}$/;
        return phoneRegex.test(phone);
    }

    function validateForm() {
        let isValid = true;

        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        document.querySelectorAll('input').forEach(input => input.classList.remove('error-field'));

        const name = document.getElementById('name').value.trim();
        if (!name) {
            document.getElementById('name-error').textContent = 'Поле имени обязательно для заполнения';
            document.getElementById('name').classList.add('error-field');
            isValid = false;
        }

        const phone = document.getElementById('phone').value;
        if (!phone) {
            document.getElementById('phone-error').textContent = 'Поле телефона обязательно для заполнения';
            document.getElementById('phone').classList.add('error-field');
            isValid = false;
        } else if (!isValidPhone(phone)) {
            document.getElementById('phone-error').textContent = 'Поле телефона должно соответствовать формату: +7 999 999 99 99';
            document.getElementById('phone').classList.add('error-field');
            isValid = false;
        }

        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            document.getElementById('email-error').textContent = 'Поле email обязательно для заполнения';
            document.getElementById('email').classList.add('error-field');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            document.getElementById('email-error').textContent = 'Введите корректный email адрес';
            document.getElementById('email').classList.add('error-field');
            isValid = false;
        }

        return isValid;
    }

    document.getElementById('contactForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        document.getElementById('messageContainer').innerHTML = '';

        const csrfToken = document.querySelector('input[name="_token"]').value;
        const formData = new FormData(this);
        const data = {
            name: formData.get('name'),
            phone: formData.get('phone'),
            email: formData.get('email'),
            _token: csrfToken
        };

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';

        try {
            const response = await axios.post('{{ route("contact.store") }}', data);

            const successDiv = document.createElement('div');
            successDiv.className = 'notification success';
            successDiv.textContent = response.data.message;
            document.getElementById('messageContainer').appendChild(successDiv);

            this.reset();
        } catch (error) {
            let message = 'Произошла ошибка при отправке формы.';
            let errorClass = 'error';

            if (error.response && error.response.data) {
                if (error.response.data.errors) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(field => {
                        const errorElement = document.getElementById(field + '-error');
                        if (errorElement) {
                            errorElement.textContent = errors[field][0];
                            document.getElementById(field).classList.add('error-field');
                        }
                    });
                }
                if (error.response.data.message) {
                    message = error.response.data.message;
                }
            } else if (error.request) {
                message = 'Нет ответа от сервера. Проверьте подключение.';
            }

            const errorDiv = document.createElement('div');
            errorDiv.className = `notification ${errorClass}`;
            errorDiv.textContent = message;
            document.getElementById('messageContainer').appendChild(errorDiv);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить';
        }
    });

    document.getElementById('phone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value.startsWith('7') || value.startsWith('8')) {
            value = value.substring(1);
        }

        if (value.length > 10) value = value.substring(0, 10);

        let formatted = '+7 ';
        if (value.length > 0) formatted += value.substring(0, 3);
        if (value.length >= 4) formatted += ' ' + value.substring(3, 6);
        if (value.length >= 7) formatted += ' ' + value.substring(6, 8);
        if (value.length >= 9) formatted += ' ' + value.substring(8, 10);

        e.target.value = formatted;

        if (isValidPhone(e.target.value)) {
            document.getElementById('phone-error').textContent = '';
            e.target.classList.remove('error-field');
        }
    });

    document.getElementById('phone').addEventListener('blur', function(e) {
        if (e.target.value && !isValidPhone(e.target.value)) {
            document.getElementById('phone-error').textContent = 'Поле телефона должно соответствовать формату: +7 999 999 99 99';
            e.target.classList.add('error-field');
        }
    });

    document.getElementById('name').addEventListener('input', function(e) {
        if (e.target.value.trim()) {
            document.getElementById('name-error').textContent = '';
            e.target.classList.remove('error-field');
        }
    });

    document.getElementById('email').addEventListener('input', function(e) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (e.target.value.trim() && emailRegex.test(e.target.value.trim())) {
            document.getElementById('email-error').textContent = '';
            e.target.classList.remove('error-field');
        }
    });
</script>
</body>
</html>
