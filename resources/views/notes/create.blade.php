<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать заметку</title>
</head>
<body>
    <h1>Создать новую заметку</h1>

    {{-- Отображение ошибок валидации --}}
    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Форма создания --}}
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf {{-- Токен защиты --}}

        <div>
            <label>Название:</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label>Описание:</label><br>
            <textarea name="description" rows="5" cols="50" required>{{ old('description') }}</textarea>
        </div>

        <div>
            <label>Дата:</label><br>
            <input type="date" name="note_date" value="{{ old('note_date') }}" required>
        </div>

        <br>
        <button type="submit">Сохранить</button>
        <a href="{{ route('notes.index') }}">
            <button type="button">Отмена</button>
        </a>
    </form>
</body>
</html>