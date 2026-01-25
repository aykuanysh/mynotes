<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заметка: {{ $note->title }}</title>
</head>
<body>
    <h1>{{ $note->title }}</h1>

    <p><strong>Дата:</strong> {{ $note->date }}</p>
    
    <p><strong>Описание:</strong></p>
    <p>{{ $note->description }}</p>

    <hr>

    <p><small>Создано: {{ $note->created_at }}</small></p>
    <p><small>Обновлено: {{ $note->updated_at }}</small></p>

    <hr>

    <a href="{{ route('notes.edit', $note->id) }}">
        <button>Редактировать</button>
    </a>

    <a href="{{ route('notes.index') }}">
        <button>Назад к списку</button>
    </a>

    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Удалить заметку?')">Удалить</button>
    </form>
</body>
</html>