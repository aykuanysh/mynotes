<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика заметок</title>
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
            max-width: 900px;
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
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
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
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            border-top: 5px solid #667eea;
        }

        .stat-card .number {
            font-size: 48px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-card .label {
            color: #666;
            font-size: 16px;
        }

        .note-info {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            border-left: 5px solid #667eea;
        }

        .note-info h3 {
            color: #333;
            margin-bottom: 8px;
        }

        .note-info p {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Статистика заметок</h1>
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">← Заметки</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="number">{{ $stats['total'] }}</div>
                <div class="label">Всего заметок</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['last_7_days'] }}</div>
                <div class="label">За последние 7 дней</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['last_30_days'] }}</div>
                <div class="label">За последние 30 дней</div>
            </div>
        </div>

        @if($stats['oldest'])
        <div class="note-info">
            <h3>Самая старая заметка</h3>
            <p>{{ $stats['oldest']['title'] }} — {{ $stats['oldest']['date'] }}</p>
        </div>
        @endif

        @if($stats['newest'])
        <div class="note-info">
            <h3>Самая новая заметка</h3>
            <p>{{ $stats['newest']['title'] }} — {{ $stats['newest']['date'] }}</p>
        </div>
        @endif
    </div>
</body>

</html>