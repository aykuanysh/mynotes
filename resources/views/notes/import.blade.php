<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Импорт заметок</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .info-box p {
            margin: 5px 0;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="url"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="url"]:focus {
            outline: none;
            border-color: #2196F3;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #2196F3;
            color: white;
        }

        .btn-primary:hover {
            background: #1976D2;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .alert-error {
            background: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            list-style: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📥 Импорт заметок</h1>

        <!-- Информационный блок -->
        <div class="info-box">
            <p><strong>ℹ️ Информация:</strong></p>
            <p>• Будут импортированы первые 10 заметок из API</p>
            <p>• Импорт выполняется в фоновом режиме</p>
            <p>• Заметки появятся через несколько секунд</p>
        </div>

        <!-- Ошибки валидации -->
        @if($errors->any())
        <div class="alert-error">
            <strong>⚠️ Ошибки:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Форма -->
        <form action="{{ route('notes.import.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="api_url">🔗 URL API *</label>
                <input
                    type="url"
                    id="api_url"
                    name="api_url"
                    value="{{ old('api_url', 'https://jsonplaceholder.typicode.com/posts') }}"
                    required
                    placeholder="https://jsonplaceholder.typicode.com/posts">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">▶️ Запустить импорт</button>
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</body>

</html>