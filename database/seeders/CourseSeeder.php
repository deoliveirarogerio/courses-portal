<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Desenvolvimento Web com Laravel',
                'description' => 'Aprenda a criar aplicações web modernas e robustas utilizando o framework Laravel. Este curso aborda desde conceitos básicos até técnicas avançadas de desenvolvimento.',
                'price' => 299.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(2),
                'remaining_slots' => 50,
            ],
            [
                'title' => 'JavaScript Moderno e React',
                'description' => 'Domine JavaScript ES6+ e React para criar interfaces de usuário interativas e responsivas. Inclui hooks, context API e melhores práticas.',
                'price' => 349.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(3),
                'remaining_slots' => 30,
            ],
            [
                'title' => 'Python para Data Science',
                'description' => 'Explore o mundo da ciência de dados com Python. Aprenda pandas, numpy, matplotlib e técnicas de análise de dados.',
                'price' => 399.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(1),
                'remaining_slots' => 25,
            ],
            [
                'title' => 'Design UX/UI Completo',
                'description' => 'Aprenda a criar experiências digitais incríveis. Desde pesquisa de usuário até prototipagem e testes de usabilidade.',
                'price' => 279.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(2),
                'remaining_slots' => 40,
            ],
            [
                'title' => 'Marketing Digital Avançado',
                'description' => 'Estratégias completas de marketing digital: SEO, SEM, redes sociais, e-mail marketing e análise de métricas.',
                'price' => 249.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(3),
                'remaining_slots' => 60,
            ],
            [
                'title' => 'DevOps e Cloud Computing',
                'description' => 'Aprenda a implementar práticas DevOps e trabalhar com cloud computing usando AWS, Docker e Kubernetes.',
                'price' => 449.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(2),
                'remaining_slots' => 20,
            ],
            [
                'title' => 'Gestão de Projetos Ágeis',
                'description' => 'Domine metodologias ágeis como Scrum e Kanban para gerenciar projetos de forma eficiente e produtiva.',
                'price' => 199.90,
                'status' => 'ativo',
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(4),
                'remaining_slots' => 80,
            ],
            [
                'title' => 'Inteligência Artificial com Python',
                'description' => 'Introdução à IA e Machine Learning. Aprenda algoritmos, redes neurais e como implementar soluções de IA.',
                'price' => 499.90,
                'status' => "inativo",
                'registration_start' => Carbon::now()->addMonth(),
                'registration_end' => Carbon::now()->addMonths(4),
                'remaining_slots' => 15,
            ],
            [
                'title' => 'Fotografia Digital Profissional',
                'description' => 'Técnicas avançadas de fotografia digital, edição no Lightroom e Photoshop, e como monetizar suas habilidades.',
                'price' => 329.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(2),
                'remaining_slots' => 35,
            ],
            [
                'title' => 'Inglês para Negócios',
                'description' => 'Desenvolva suas habilidades em inglês focado no ambiente corporativo. Apresentações, reuniões e comunicação profissional.',
                'price' => 179.90,
                'status' => "ativo",
                'registration_start' => Carbon::now(),
                'registration_end' => Carbon::now()->addMonths(6),
                'remaining_slots' => 100,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}