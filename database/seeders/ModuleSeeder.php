<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Para cada curso, cria 2 módulos
        foreach (Course::all() as $course) {
            Module::create([
                'course_id' => $course->id,
                'title' => 'Módulo 1: Introdução ao ' . $course->title,
                'description' => 'Primeiros passos no curso de ' . $course->title,
                'order' => 1,
            ]);
            Module::create([
                'course_id' => $course->id,
                'title' => 'Módulo 2: Avançando em ' . $course->title,
                'description' => 'Conteúdo intermediário/avançado de ' . $course->title,
                'order' => 2,
            ]);
        }
    }
} 