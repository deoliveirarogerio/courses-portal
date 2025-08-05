<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatRoom;
use App\Models\User;

class ChatRoomSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('type', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        $rooms = [
            [
                'name' => 'Sala Geral',
                'description' => 'Conversa geral entre alunos e instrutores',
                'type' => 'public',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'name' => 'Dúvidas de Programação',
                'description' => 'Tire suas dúvidas sobre programação',
                'type' => 'public',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'name' => 'Projetos e Portfólio',
                'description' => 'Compartilhe seus projetos e receba feedback',
                'type' => 'public',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'name' => 'Networking',
                'description' => 'Conecte-se com outros desenvolvedores',
                'type' => 'public',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'name' => 'Oportunidades de Trabalho',
                'description' => 'Compartilhe e encontre oportunidades',
                'type' => 'public',
                'created_by' => $admin->id,
                'is_active' => true,
            ]
        ];

        foreach ($rooms as $room) {
            ChatRoom::create($room);
        }
    }
}