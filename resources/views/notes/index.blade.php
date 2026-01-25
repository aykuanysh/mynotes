<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заметки</title>
</head>
<body>
    <h1>Список заметок</h1>

    {{-- Сообщение об успехе --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Кнопка создания новой заметки --}}
    <a href="{{ route('notes.create') }}">
        <button>Создать новую заметку</button>
    </a>

    <hr>

    {{-- Проверка: есть ли заметки --}}
    @if($notes->count() > 0)
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                {{-- Цикл по всем заметкам --}}
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->id }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->date }}</td>
                        <td>
                            {{-- Кнопка просмотра --}}
                            <a href="{{ route('notes.show', $note->id) }}">
                                <button>Просмотр</button>
                            </a>
                            
                            {{-- Кнопка редактирования --}}
                            <a href="{{ route('notes.edit', $note->id) }}">
                                <button>Редактировать</button>
                            </a>
                            
                            {{-- Форма удаления --}}
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Удалить заметку?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Заметок пока нет. Создайте первую!</p>
    @endif
</body>
</html>