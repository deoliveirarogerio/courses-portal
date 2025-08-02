<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        $this->call([
            CourseSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,
        ]);

        // Adicione uma matrícula para o usuário ID 2 no curso 3
        DB::table('enrollments')->insert([
            'course_id' => 3,
            'student_id' => 2,
            'progress' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

