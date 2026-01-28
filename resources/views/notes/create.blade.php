<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать заметку</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header h1 {
            color: #667eea;
            font-size: 24px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .btn-success {
            background: #51cf66;
            color: white;
        }

        .btn-success:hover {
            background: #40c057;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .alert-error {
            background: #ff6b6b;
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .alert-error ul {
            list-style: none;
            margin-top: 10px;
        }

        .alert-error li {
            padding: 5px 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .form-container {
                padding: 25px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Шапка -->
        <div class="header">
            <h1>➕ Создать заметку</h1>
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">← К списку</a>
        </div>

        <!-- Форма -->
        <div class="form-container">
            @if($errors->any())
            <div class="alert-error">
                <strong>⚠️ Ошибки валидации:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('notes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">📝 Название заметки *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Введите название...">
                </div>

                <div class="form-group">
                    <label for="description">📄 Описание *</label>
                    <textarea id="description" name="description" required placeholder="Опишите вашу заметку...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="note_date">📅 Дата *</label>
                    <input type="date"
                        name="note_date"
                        value="{{ old('note_date') }}"
                        min="1900-01-01"
                        max="2100-12-31"
                        required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">✓ Сохранить заметку</button>
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>