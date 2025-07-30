<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email} {password}';
    protected $description = 'Criar um usuário administrador';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        // Verificar se já existe
        if (User::where('email', $email)->exists()) {
            $this->error('Usuário com este email já existe!');
            return;
        }
        
        $user = User::create([
            'name' => 'Administrador',
            'email' => $email,
            'password' => Hash::make($password),
            'type' => 'admin',
            'status' => 'active'
        ]);
        
        $this->info("Usuário admin criado com sucesso!");
        $this->line("Email: {$user->email}");
        $this->line("Tipo: {$user->type}");
    }
} 