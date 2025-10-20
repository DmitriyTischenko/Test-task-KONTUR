<!DOCTYPE html>
<html>
<head>
    <title>Новый контакт</title>
</head>
<body>
<h2>Получены данные с контактной формы</h2>
<p><strong>Имя:</strong> {{ $contact->name }}</p>
<p><strong>Телефон:</strong> {{ $contact->phone }}</p>
<p><strong>Email:</strong> {{ $contact->email }}</p>
</body>
</html>
