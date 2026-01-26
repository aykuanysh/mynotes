<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Заполнение базы данных тестовыми данными
     */
    public function run(): void
    {
        // Создаем тестового пользователя #1
        $user1 = User::create([
            'name' => 'Иван Иванов',
            'email' => 'ivan@test.com',
            'password' => Hash::make('password'), // Пароль: password
            'email_verified_at' => now(),
        ]);

        // Создаем заметки для Ивана
        Note::create([
            'user_id' => $user1->id,
            'title' => 'Купить продукты',
            'description' => 'Молоко, хлеб, яйца, масло',
            'note_date' => now()->subDays(2), // 2 дня назад
        ]);

        Note::create([
            'user_id' => $user1->id,
            'title' => 'Встреча с клиентом',
            'description' => 'Обсудить новый проект. Адрес: ул. Пушкина, д.10',
            'note_date' => now()->addDays(3), // Через 3 дня
        ]);

        Note::create([
            'user_id' => $user1->id,
            'title' => 'Изучить Laravel',
            'description' => 'Пройти курс по Laravel. Темы: Eloquent, Blade, Middleware',
            'note_date' => now(), // Сегодня
        ]);

        // Создаем тестового пользователя #2
        $user2 = User::create([
            'name' => 'Мария Петрова',
            'email' => 'maria@test.com',
            'password' => Hash::make('password'), // Пароль: password
            'email_verified_at' => now(),
        ]);

        // Создаем заметки для Марии
        Note::create([
            'user_id' => $user2->id,
            'title' => 'День рождения мамы',
            'description' => 'Не забыть купить подарок и торт!',
            'note_date' => now()->addDays(7), // Через неделю
        ]);

        Note::create([
            'user_id' => $user2->id,
            'title' => 'Поход к врачу',
            'description' => 'Стоматолог, 15:00, клиника на Ленина',
            'note_date' => now()->addDay(), // Завтра
        ]);

        // Создаем пользователя #3 (твой основной для тестов)
        $user3 = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Создаем 10 случайных заметок для Test User
        for ($i = 1; $i <= 10; $i++) {
            Note::create([
                'user_id' => $user3->id,
                'title' => "Заметка #{$i}",
                'description' => "Описание тестовой заметки номер {$i}. Здесь может быть любой текст.",
                'note_date' => now()->addDays(rand(-30, 30)), // От -30 до +30 дней
            ]);
        }

        // Выводим сообщение об успешном создании
        $this->command->info('✅ Создано 3 пользователя');
        $this->command->info('✅ Создано ' . Note::count() . ' заметок');
        $this->command->info('');
        $this->command->info('📧 Тестовые пользователи:');
        $this->command->info('   Email: ivan@test.com   | Пароль: password');
        $this->command->info('   Email: maria@test.com  | Пароль: password');
        $this->command->info('   Email: test@test.com   | Пароль: password');
    }
}