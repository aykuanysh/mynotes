<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заметки</title>
</head>
<body>
    <div style="background: #f0f0f0; padding: 10px; margin-bottom: 20px;">
        <span>Привет, {{ Auth::user()->name }}!</span>
        
        <form action="{{ route('logout') }}" method="POST" style="display:inline; float:right;">
            @csrf
            <button type="submit">Выйти</button>
        </form>
        
        <a href="{{ route('dashboard') }}" style="margin-left: 20px;">
            <button type="button">Панель</button>
        </a>
    </div>

    <h1>Мои заметки</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('notes.create') }}">
        <button>Создать новую заметку</button>
    </a>

    <hr>

    @if($notes->count() > 0)
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Название</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->user_note_id }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->note_date->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('notes.show', $note->id) }}">
                                <button>Просмотр</button>
                            </a>
                            
                            <a href="{{ route('notes.edit', $note->id) }}">
                                <button>Редактировать</button>
                            </a>
                            
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