@extends('web._theme')

@section('title', 'Início - Portal de Cursos')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-2 fw-bold mb-4">Bem-vindo ao<br/><span class="text-warning">Portal de Cursos</span></h1>
                <p class="lead mb-4">Descubra os melhores cursos online e desenvolva suas habilidades com instrutores especializados. Aprenda no seu ritmo e transforme sua carreira.</p>
                <div class="d-flex gap-3">
                    <a href="#courses" class="btn btn-light btn-lg">Ver Cursos</a>
                    <a href="{{ route('web.about') }}" class="btn btn-outline-light btn-lg">Saiba Mais</a>
                </div>
            </div>
            <div class="col-lg-6 text-center my-0 py-0">
                <img src="{{ asset('web/img/student.png') }}" alt="Estudante" title="Estudante"/>
                <!-- <i class="bi bi-laptop display-1 opacity-75"></i> -->
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-people-fill text-primary display-4 mb-3"></i>
                        <h3 class="fw-bold">1000+</h3>
                        <p class="text-muted">Estudantes Ativos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-book-fill text-success display-4 mb-3"></i>
                        <h3 class="fw-bold">{{ $courses->count() }}</h3>
                        <p class="text-muted">Cursos Disponíveis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-award-fill text-warning display-4 mb-3"></i>
                        <h3 class="fw-bold">95%</h3>
                        <p class="text-muted">Taxa de Satisfação</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-clock-fill text-info display-4 mb-3"></i>
                        <h3 class="fw-bold">24/7</h3>
                        <p class="text-muted">Suporte Online</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section id="courses" class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">Cursos Populares</h2>
                <p class="lead text-muted">Explore nossa seleção de cursos mais procurados e comece sua jornada de aprendizado hoje mesmo.</p>
            </div>
        </div>
        
        @if($courses->count() > 0)
            <div class="row">
                @foreach ($courses->take(6) as $course)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card course-card h-100 shadow-sm">
                            <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                                <i class="bi bi-mortarboard display-6"></i>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-3">{{ $course->title }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->description, 100) }}</p>
                                
                                <div class="course-info mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-badge">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                        <small class="text-muted">
                                            <i class="bi bi-people-fill me-1"></i>{{ $course->remaining_slots }} vagas
                                        </small>
                                    </div>
                                    
                                    @if($course->registration_start && $course->registration_end)
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Inscrições: {{ date('d/m/Y', strtotime($course->registration_start)) }} - {{ date('d/m/Y', strtotime($course->registration_end)) }}
                                        </small>
                                    @endif
                                </div>
                                
                                <div class="d-grid">
                                    <a href="{{ route('web.courses.details', $course->id) }}" class="btn btn-primary">
                                        <i class="bi bi-eye me-2"></i>Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($courses->count() > 6)
                <div class="text-center mt-4">
                    <a href="{{ route('web.courses.index') }}" class="btn btn-outline-primary btn-lg">
                        Ver Todos os Cursos <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3 text-muted">Nenhum curso disponível no momento</h3>
                <p class="text-muted">Novos cursos serão adicionados em breve. Fique atento!</p>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">Por que escolher nosso portal?</h2>
                <p class="lead text-muted">Oferecemos a melhor experiência de aprendizado online com recursos exclusivos.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-play-circle-fill text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Aulas em Vídeo</h4>
                    <p class="text-muted">Conteúdo em alta qualidade com explicações detalhadas e exemplos práticos.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-patch-check text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Certificação</h4>
                    <p class="text-muted">Receba certificados reconhecidos no mercado ao concluir os cursos.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-headset text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Suporte 24/7</h4>
                    <p class="text-muted">Nossa equipe está sempre disponível para ajudar você em sua jornada.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h2 class="display-5 fw-bold mb-3">Pronto para começar?</h2>
                <p class="lead mb-4">Junte-se a milhares de estudantes que já transformaram suas carreiras conosco.</p>
                <a href="#" class="btn btn-light btn-lg me-3">Criar Conta Grátis</a>
                <a href="#" class="btn btn-outline-light btn-lg">Falar com Consultor</a>
            </div>
        </div>
    </div>
</section>
@endsection
