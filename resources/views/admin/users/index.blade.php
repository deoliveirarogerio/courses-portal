@extends('admin.layouts.app')

@section('title', 'Usuários - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Gerenciar Usuários</h2>
                <p class="text-muted mb-0">Gerencie todos os usuários da plataforma</p>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Novo Usuário
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @switch($user->type)
                                        @case('admin')
                                            <span class="badge bg-danger">Administrador</span>
                                            @break
                                        @case('instrutor')
                                            <span class="badge bg-warning">Instrutor</span>
                                            @break
                                        @case('aluno')
                                            <span class="badge bg-primary">Aluno</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Usuário</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($user->status)
                                        @case('active')
                                            <span class="badge bg-success">Ativo</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge bg-secondary">Inativo</span>
                                            @break
                                        @case('suspended')
                                            <span class="badge bg-warning">Suspenso</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-info">Pendente</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Desconhecido</span>
                                    @endswitch
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Nenhum usuário cadastrado</h5>
                <p class="text-muted">Comece criando seu primeiro usuário!</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Criar Primeiro Usuário
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 