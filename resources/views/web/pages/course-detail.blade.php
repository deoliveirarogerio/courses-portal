@extends('web._theme')

@section('title', $course->title . ' - Portal de Cursos')

@section('content')
<!-- Course Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home') }}" class="text-white-50">Início</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-white-50">Cursos</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $course->title }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold text-white mb-3">{{ $course->title }}</h1>
                <p class="lead text-white-75 mb-4">{{ $course->description }}</p>
                
                <div class="d-flex flex-wrap gap-3 mb-4">
                    @if($course->status === 'ativo')
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Disponível
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2">
                            <i class="bi bi-x-circle me-1"></i>Indisponível
                        </span>
                    @endif
                    
                    <span class="badge bg-info fs-6 px-3 py-2">
                        <i class="bi bi-people me-1"></i>{{ $course->remaining_slots }} vagas disponíveis
                    </span>
                    
                    @if($course->registration_start && $course->registration_end)
                        <span class="badge bg-warning fs-6 px-3 py-2">
                            <i class="bi bi-calendar-event me-1"></i>
                            Inscrições até {{ date('d/m/Y', strtotime($course->registration_end)) }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-4">
                        <div class="display-4 fw-bold text-primary mb-3">
                            R$ {{ number_format($course->price, 2, ',', '.') }}
                        </div>
                        
                        @if($course->status === 'ativo' && $course->remaining_slots > 0)
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#enrollModal">
                                    <i class="bi bi-cart-plus me-2"></i>Inscrever-se Agora
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-heart me-2"></i>Adicionar aos Favoritos
                                </button>
                            </div>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="bi bi-x-circle me-2"></i>Curso Indisponível
                            </button>
                        @endif
                        
                        <hr class="my-3">
                        
                        <div class="text-start">
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-clock me-2"></i>Duração: 40 horas
                            </small>
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-award me-2"></i>Certificado incluso
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-laptop me-2"></i>Acesso vitalício
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Course Description -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Sobre o Curso</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $course->description }}</p>
                        
                        <h5 class="mt-4 mb-3">O que você vai aprender:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fundamentos essenciais da área</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Técnicas avançadas e melhores práticas</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Projetos práticos do mundo real</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Preparação para certificações</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Networking com outros profissionais</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Course Curriculum -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Conteúdo do Curso</h3>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="curriculumAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#module1">
                                        <strong>Módulo 1: Introdução</strong>
                                        <span class="badge bg-primary ms-auto me-3">5 aulas</span>
                                    </button>
                                </h2>
                                <div id="module1" class="accordion-collapse collapse show" data-bs-parent="#curriculumAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span><i class="bi bi-play-circle me-2"></i>Apresentação do curso</span>
                                                <small class="text-muted">10 min</small>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span><i class="bi bi-play-circle me-2"></i>Conceitos fundamentais</span>
                                                <small class="text-muted">25 min</small>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span><i class="bi bi-file-text me-2"></i>Material de apoio</span>
                                                <small class="text-muted">PDF</small>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module2">
                                        <strong>Módulo 2: Desenvolvimento Prático</strong>
                                        <span class="badge bg-primary ms-auto me-3">8 aulas</span>
                                    </button>
                                </h2>
                                <div id="module2" class="accordion-collapse collapse" data-bs-parent="#curriculumAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span><i class="bi bi-play-circle me-2"></i>Primeiros passos práticos</span>
                                                <small class="text-muted">30 min</small>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span><i class="bi bi-play-circle me-2"></i>Projeto prático 1</span>
                                                <small class="text-muted">45 min</small>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module3">
                                        <strong>Módulo 3: Avançado</strong>
                                        <span class="badge bg-primary ms-auto me-3">6 aulas</span>
                                    </button>
                                </h2>
                                <div id="module3" class="accordion-collapse collapse" data-bs-parent="#curriculumAccordion">
                                    <div class="accordion-body">
                                        <p class="text-muted">Conteúdo avançado para aprofundar seus conhecimentos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Avaliações dos Estudantes</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="display-4 fw-bold text-warning">4.8</div>
                                <div class="text-warning mb-2">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <small class="text-muted">Baseado em 127 avaliações</small>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">5</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 75%"></div>
                                        </div>
                                        <small class="text-muted">75%</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">4</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 20%"></div>
                                        </div>
                                        <small class="text-muted">20%</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">3</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 3%"></div>
                                        </div>
                                        <small class="text-muted">3%</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">2</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 1%"></div>
                                        </div>
                                        <small class="text-muted">1%</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">1</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 1%"></div>
                                        </div>
                                        <small class="text-muted">1%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Individual Reviews -->
                        <div class="border-top pt-4">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">JS</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">João Silva</h6>
                                        <div class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted ms-auto">há 2 dias</small>
                                </div>
                                <p class="mb-0">Excelente curso! O conteúdo é muito bem estruturado e os exemplos práticos ajudam muito no aprendizado. Recomendo!</p>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">MS</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Maria Santos</h6>
                                        <div class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted ms-auto">há 1 semana</small>
                                </div>
                                <p class="mb-0">Muito bom curso, aprendi bastante. O instrutor explica de forma clara e didática.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Instructor Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Instrutor</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold" style="font-size: 1.5rem;">PR</span>
                        </div>
                        <h5 class="fw-bold">Prof. Pedro Rodrigues</h5>
                        <p class="text-muted mb-3">Especialista em Tecnologia com mais de 10 anos de experiência</p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-light text-dark">15 cursos</span>
                            <span class="badge bg-light text-dark">4.9 ⭐</span>
                            <span class="badge bg-light text-dark">2.5k estudantes</span>
                        </div>
                    </div>
                </div>
                
                <!-- Related Courses -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Cursos Relacionados</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex">
                                <div class="bg-secondary rounded me-3" style="width: 60px; height: 60px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Curso Avançado</h6>
                                    <small class="text-muted">R$ 299,00</small>
                                    <div class="text-warning small">
                                        <i class="bi bi-star-fill"></i> 4.7
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex">
                                <div class="bg-secondary rounded me-3" style="width: 60px; height: 60px;"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Curso Complementar</h6>
                                    <small class="text-muted">R$ 199,00</small>
                                    <div class="text-warning small">
                                        <i class="bi bi-star-fill"></i> 4.5
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscrever-se no Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4>{{ $course->title }}</h4>
                    <div class="display-6 fw-bold text-primary">
                        R$ {{ number_format($course->price, 2, ',', '.') }}
                    </div>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="studentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="studentEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentPhone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="studentPhone">
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Após a inscrição, você receberá um e-mail com as instruções de acesso.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-credit-card me-2"></i>Finalizar Inscrição
                </button>
            </div>
        </div>
    </div>
</div>
@endsection