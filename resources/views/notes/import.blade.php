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

        input[type="url"],
        input[type="file"] {
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

        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            cursor: pointer;
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

        .hidden {
            display: none;
        }

        .format-hint {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
            line-height: 1.5;
        }

        .format-hint code {
            background: #f0f0f0;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📥 Импорт заметок</h1>

        <!-- Информационный блок -->
        <div class="info-box">
            <p><strong>ℹ️ Информация:</strong></p>
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
        <form action="{{ route('notes.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Тип импорта</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="import_type" value="api"
                            {{ old('import_type', 'api') === 'api' ? 'checked' : '' }}>
                        Из API
                    </label>
                    <label>
                        <input type="radio" name="import_type" value="file"
                            {{ old('import_type') === 'file' ? 'checked' : '' }}>
                        Из файла (CSV, XML)
                    </label>
                </div>
            </div>

            <div class="form-group" id="api-section">
                <label for="api_url">🔗 URL API</label>
                <input
                    type="url"
                    id="api_url"
                    name="api_url"
                    value="{{ old('api_url', 'https://jsonplaceholder.typicode.com/posts') }}"
                    placeholder="https://jsonplaceholder.typicode.com/posts">
            </div>

            <div class="form-group hidden" id="file-section">
                <label for="import_file">📄 Выберите файл</label>
                <input
                    type="file"
                    id="import_file"
                    name="import_file"
                    accept=".csv,.xml">
                <div class="format-hint">
                    <strong>CSV:</strong> первая строка — заголовки <code>title,description,note_date</code><br>
                    <strong>XML:</strong> структура <code>&lt;notes&gt;&lt;note&gt;&lt;title&gt;...&lt;/title&gt;&lt;description&gt;...&lt;/description&gt;&lt;/note&gt;&lt;/notes&gt;</code><br>
                    Поле <code>note_date</code> опционально. Максимум 2 МБ.
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">▶️ Запустить импорт</button>
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="import_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var apiSection = document.getElementById('api-section');
                var fileSection = document.getElementById('file-section');

                if (this.value === 'api') {
                    apiSection.classList.remove('hidden');
                    fileSection.classList.add('hidden');
                } else {
                    apiSection.classList.add('hidden');
                    fileSection.classList.remove('hidden');
                }
            });
        });

        // Инициализация при загрузке (для корректного отображения после ошибки валидации)
        var checked = document.querySelector('input[name="import_type"]:checked');
        if (checked) {
            checked.dispatchEvent(new Event('change'));
        }
    </script>
</body>

</html>
