<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckAdminUser extends Command
{
    protected $signature = 'admin:check';
    protected $description = 'Verificar usuários admin no banco de dados';

    public function handle()
    {
        $this->info('Verificando usuários admin...');
        
        // Buscar usuários admin usando string
        $adminUsers = User::where('type', 'admin')->get();
        
        if ($adminUsers->count() > 0) {
            $this->info('Usuários admin encontrados:');
            foreach ($adminUsers as $user) {
                $this->line("- ID: {$user->id}, Nome: {$user->name}, Email: {$user->email}, Tipo: {$user->type}");
            }
        } else {
            $this->warn('Nenhum usuário admin encontrado!');
            
            $allUsers = User::all();
            $this->info('Todos os usuários no banco:');
            foreach ($allUsers as $user) {
                $this->line("- ID: {$user->id}, Nome: {$user->name}, Email: {$user->email}, Tipo: {$user->type}");
            }
        }
    }
} 