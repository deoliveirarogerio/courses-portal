@extends('admin.layouts.app')

@section('title', 'Criar Curso - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Criar Novo Curso</h2>
                <p class="text-muted mb-0">Preencha as informações do curso</p>
            </div>
            <div>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título do Curso *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="curriculum" class="form-label">Currículo</label>
                        <textarea class="form-control @error('curriculum') is-invalid @enderror" 
                                  id="curriculum" name="curriculum" rows="6">{{ old('curriculum') }}</textarea>
                        @error('curriculum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Imagem do Curso</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Formatos aceitos: JPG, PNG. Máximo 2MB.</small>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Preço *</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', 0) }}" 
                                   step="0.01" min="0" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Duração</label>
                        <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" value="{{ old('duration') }}" 
                               placeholder="Ex: 40 horas">
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="difficulty_level" class="form-label">Nível de Dificuldade *</label>
                        <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                id="difficulty_level" name="difficulty_level" required>
                            <option value="">Selecione...</option>
                            <option value="iniciante" {{ old('difficulty_level') == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                            <option value="intermediario" {{ old('difficulty_level') == 'intermediario' ? 'selected' : '' }}>Intermediário</option>
                            <option value="avancado" {{ old('difficulty_level') == 'avancado' ? 'selected' : '' }}>Avançado</option>
                        </select>
                        @error('difficulty_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                    <label for="instructor_id" class="form-label">Instrutor</label>
                       <select class="form-select @error('instructor') is-invalid @enderror" id="instructor_id" name="instructor_id" required> 
                        <option value="">Selecione...</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id', $instructor->id) }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach   
                        </select>   
                        @error('instructor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="max_students" class="form-label">Máximo de Alunos *</label>
                        <input type="number" class="form-control @error('max_students') is-invalid @enderror" 
                               id="max_students" name="max_students" value="{{ old('max_students', 50) }}" 
                               min="1" required>
                        @error('max_students')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">Selecione...</option>
                            <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="rascunho" {{ old('status') == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" 
                                   name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Curso em Destaque
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Criar Curso
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 