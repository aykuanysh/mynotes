<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления - MyNotes</title>
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
            max-width: 1200px;
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
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-name {
            font-size: 16px;
            color: #666;
        }

        .btn {
            padding: 10px 25px;
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
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .btn-logout {
            background: #ff6b6b;
            color: white;
        }

        .btn-logout:hover {
            background: #ee5a5a;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .card-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }

        .welcome-message {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-message h2 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .welcome-message p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .user-info {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Шапка -->
        <div class="header">
            <h1>📊 Панель управления</h1>
            <div class="user-info">
                <span class="user-name">👋 {{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Профиль</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout">Выйти</button>
                </form>
            </div>
        </div>

        <!-- Приветственное сообщение -->
        <div class="welcome-message">
            <h2>Добро пожаловать в MyNotes!</h2>
            <p>Управляйте своими заметками эффективно и просто. Все ваши записи в одном месте.</p>
        </div>

        <!-- Статистика -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->notes()->count() }}</div>
                <div class="stat-label">Всего заметок</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->notes()->whereDate('created_at', today())->count() }}</div>
                <div class="stat-label">Создано сегодня</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->notes()->where('note_date', '>=', today())->count() }}</div>
                <div class="stat-label">Предстоящих</div>
            </div>
        </div>

        <!-- Быстрые действия -->
        <h2 style="color: white; margin: 40px 0 20px 0; font-size: 24px;">Быстрые действия</h2>
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-icon">📝</div>
                <h3 class="card-title">Мои заметки</h3>
                <p class="card-description">Просмотрите все ваши заметки, отредактируйте или удалите их.</p>
                <a href="{{ route('notes.index') }}" class="btn btn-primary">Перейти к заметкам</a>
            </div>

            <div class="card">
                <div class="card-icon">➕</div>
                <h3 class="card-title">Создать заметку</h3>
                <p class="card-description">Быстро создайте новую заметку и сохраните важную информацию.</p>
                <a href="{{ route('notes.create') }}" class="btn btn-primary">Создать заметку</a>
            </div>

            <div class="card">
                <div class="card-icon">👤</div>
                <h3 class="card-title">Профиль</h3>
                <p class="card-description">Обновите информацию профиля, измените пароль или email.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
            </div>
        </div>

        <!-- Последние заметки -->
        @php
            $recentNotes = Auth::user()->notes()->orderBy('created_at', 'desc')->take(5)->get();
        @endphp

        @if($recentNotes->count() > 0)
            <h2 style="color: white; margin: 40px 0 20px 0; font-size: 24px;">📌 Последние заметки</h2>
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f0f0f0;">
                            <th style="padding: 15px; text-align: left; color: #667eea;">Название</th>
                            <th style="padding: 15px; text-align: left; color: #667eea;">Дата</th>
                            <th style="padding: 15px; text-align: left; color: #667eea;">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentNotes as $note)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td style="padding: 15px;">{{ Str::limit($note->title, 40) }}</td>
                                <td style="padding: 15px; color: #666;">{{ $note->note_date->format('d.m.Y') }}</td>
                                <td style="padding: 15px;">
                                    <a href="{{ route('notes.show', $note->id) }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 12px;">Просмотр</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>