<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Lesson;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Module::all() as $module) {
            Lesson::create([
                'module_id' => $module->id,
                'title' => 'Aula 1 - Introdução',
                'description' => 'Primeira aula do módulo.',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration' => '10 min',
                'order' => 1,
            ]);
            Lesson::create([
                'module_id' => $module->id,
                'title' => 'Aula 2 - Conteúdo Principal',
                'description' => 'Segunda aula do módulo.',
                'video_url' => 'https://www.w3schools.com/html/movie.mp4',
                'duration' => '15 min',
                'order' => 2,
            ]);
        }
    }
} 