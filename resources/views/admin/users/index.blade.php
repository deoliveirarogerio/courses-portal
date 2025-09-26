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
                @php
                    $pageUsers = $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->getCollection() : $users;
                    $admins = $pageUsers->filter(fn($u) => method_exists($u, 'isAdmin') ? $u->isAdmin() : ($u->type === 'admin'));
                    $instrutores = $pageUsers->filter(fn($u) => method_exists($u, 'isInstrutor') ? $u->isInstrutor() : ($u->type === 'instrutor'));
                    $alunos = $pageUsers->filter(fn($u) => method_exists($u, 'isAluno') ? $u->isAluno() : ($u->type === 'aluno'));
                @endphp

                <ul class="nav nav-tabs mb-3" id="usersTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-admins" data-bs-toggle="tab" data-bs-target="#pane-admins" type="button" role="tab" aria-controls="pane-admins" aria-selected="true">
                            Administradores <span class="badge bg-light text-dark ms-1">{{ $admins->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-instrutores" data-bs-toggle="tab" data-bs-target="#pane-instrutores" type="button" role="tab" aria-controls="pane-instrutores" aria-selected="false">
                            Instrutores <span class="badge bg-light text-dark ms-1">{{ $instrutores->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-alunos" data-bs-toggle="tab" data-bs-target="#pane-alunos" type="button" role="tab" aria-controls="pane-alunos" aria-selected="false">
                            Alunos <span class="badge bg-light text-dark ms-1">{{ $alunos->count() }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="usersTabContent">
                    <div class="tab-pane fade show active" id="pane-admins" role="tabpanel" aria-labelledby="tab-admins">
                        @include('admin.users.partials.table', ['usersList' => $admins, 'usersPaginator' => $users])
                    </div>
                    <div class="tab-pane fade" id="pane-instrutores" role="tabpanel" aria-labelledby="tab-instrutores">
                        @include('admin.users.partials.table', ['usersList' => $instrutores, 'usersPaginator' => $users])
                    </div>
                    <div class="tab-pane fade" id="pane-alunos" role="tabpanel" aria-labelledby="tab-alunos">
                        @include('admin.users.partials.table', ['usersList' => $alunos, 'usersPaginator' => $users])
                    </div>
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
