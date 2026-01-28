<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $note->title }}</title>
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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

        .header-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-warning {
            background: #ffa94d;
            color: white;
        }

        .btn-warning:hover {
            background: #ff922b;
        }

        .btn-danger {
            background: #ff6b6b;
            color: white;
        }

        .btn-danger:hover {
            background: #ee5a5a;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .note-content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .note-badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .note-title {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .note-meta {
            display: flex;
            gap: 30px;
            padding: 20px 0;
            border-top: 2px solid #f0f0f0;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .note-description {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            margin-bottom: 40px;
            white-space: pre-wrap;
        }

        .note-actions {
            display: flex;
            gap: 15px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .note-content {
                padding: 25px;
            }

            .note-title {
                font-size: 28px;
            }

            .note-meta {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Шапка -->
        <div class="header">
            <h1>📖 Просмотр заметки</h1>
            <div class="header-buttons">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">← К списку</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Панель</a>
            </div>
        </div>

        <!-- Содержимое заметки -->
        <div class="note-content">
            <span class="note-badge"># {{ $note->user_note_id }}</span>
            
            <h1 class="note-title">{{ $note->title }}</h1>

            <div class="note-meta">
                <div class="meta-item">
                    📅 <strong>Дата заметки:</strong> {{ $note->note_date->format('d.m.Y') }}
                </div>
                <div class="meta-item">
                    🕒 <strong>Создано:</strong> {{ $note->created_at->format('d.m.Y H:i') }}
                </div>
                <div class="meta-item">
                    ✏️ <strong>Изменено:</strong> {{ $note->updated_at->format('d.m.Y H:i') }}
                </div>
            </div>

            <div class="note-description">{{ $note->description }}</div>

            <div class="note-actions">
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning">✏️ Редактировать</a>
                <a href="{{ route('notes.index') }}" class="btn btn-primary">← Назад к списку</a>
                <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить заметку?')">🗑️ Удалить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>