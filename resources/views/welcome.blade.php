<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotes - Система управления заметками</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 60px 80px;
            text-align: center;
            max-width: 600px;
            width: 90%;
        }

        h1 {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 40px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .features {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            text-align: left;
        }

        .feature {
            padding: 20px;
            background: #f8f9ff;
            border-radius: 10px;
        }

        .feature h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .feature p {
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 40px 30px;
            }

            h1 {
                font-size: 36px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 MyNotes</h1>
        <p>Простая и удобная система для управления вашими заметками. Создавайте, редактируйте и организуйте свои мысли в одном месте.</p>

        <div class="buttons">
            @auth
                <a href="{{ route('notes.index') }}" class="btn btn-primary">Мои заметки</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Регистрация</a>
            @endauth
        </div>

        <div class="features">
            <div class="feature">
                <h3>🔒 Безопасность</h3>
                <p>Ваши заметки защищены. Только вы имеете к ним доступ.</p>
            </div>
            <div class="feature">
                <h3>⚡ Быстро</h3>
                <p>Создавайте и редактируйте заметки моментально.</p>
            </div>
            <div class="feature">
                <h3>📅 Даты</h3>
                <p>Привязывайте даты к заметкам для лучшей организации.</p>
            </div>
            <div class="feature">
                <h3>🎯 Просто</h3>
                <p>Минималистичный интерфейс без лишних функций.</p>
            </div>
        </div>
    </div>
</body>
</html>