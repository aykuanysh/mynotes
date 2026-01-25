<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать: {{ $note->title }}</title>
</head>
<body>
    <h1>Редактировать заметку</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Форма редактирования --}}
    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Метод PUT для обновления --}}

        <div>
            <label>Название:</label><br>
            <input type="text" name="title" value="{{ old('title', $note->title) }}" required>
        </div>

        <div>
            <label>Описание:</label><br>
            <textarea name="description" rows="5" cols="50" required>{{ old('description', $note->description) }}</textarea>
        </div>

        <div>
            <label>Дата:</label><br>
            <input type="date" name="date" value="{{ old('date', $note->date) }}" required>
        </div>

        <br>
        <button type="submit">Обновить</button>
        <a href="{{ route('notes.index') }}">
            <button type="button">Отмена</button>
        </a>
    </form>
</body>
</html>