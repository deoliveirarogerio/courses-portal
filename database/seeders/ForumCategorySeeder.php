<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumCategory;

class ForumCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Dúvidas Gerais',
                'description' => 'Tire suas dúvidas sobre os cursos e conteúdos',
                'icon' => 'bi-question-circle',
                'color' => '#007bff',
                'sort_order' => 1
            ],
            [
                'name' => 'Programação',
                'description' => 'Discussões sobre linguagens de programação e desenvolvimento',
                'icon' => 'bi-code-slash',
                'color' => '#28a745',
                'sort_order' => 2
            ],
            [
                'name' => 'Projetos',
                'description' => 'Compartilhe seus projetos e receba feedback',
                'icon' => 'bi-folder',
                'color' => '#ffc107',
                'sort_order' => 3
            ],
            [
                'name' => 'Carreira',
                'description' => 'Dicas de carreira e mercado de trabalho',
                'icon' => 'bi-briefcase',
                'color' => '#17a2b8',
                'sort_order' => 4
            ],
            [
                'name' => 'Networking',
                'description' => 'Conecte-se com outros alunos e profissionais',
                'icon' => 'bi-people',
                'color' => '#6f42c1',
                'sort_order' => 5
            ],
            [
                'name' => 'Sugestões',
                'description' => 'Sugestões para melhorar a plataforma',
                'icon' => 'bi-lightbulb',
                'color' => '#fd7e14',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $category) {
            ForumCategory::create($category);
        }
    }
}