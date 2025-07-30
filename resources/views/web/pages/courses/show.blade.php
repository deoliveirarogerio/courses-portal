
@extends('web._theme')

@section('title', ($course->title ?? 'Detalhes do Curso') . ' - Portal de Cursos')

@section('content')
    <!-- Course Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('web.home') }}" class="text-white-50">
                                    <i class="bi bi-house-fill me-1"></i>Início
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('web.courses.index') }}" class="text-white-50">Cursos</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ Str::limit($course->title ?? 'Desenvolvimento Web com Laravel', 50) }}
                            </li>
                        </ol>
                    </nav>

                    <div class="text-white mb-4">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge bg-light text-dark px-3 py-2">
                            <i class="bi bi-tag-fill me-1"></i>{{ $course->category ?? 'Programação' }}
                        </span>
                            <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i>Certificado Incluso
                        </span>
                            @if(($course->difficulty ?? 'Intermediário') === 'Iniciante')
                                <span class="badge bg-info px-3 py-2">
                                <i class="bi bi-star-fill me-1"></i>Iniciante
                            </span>
                            @elseif(($course->difficulty ?? 'Intermediário') === 'Avançado')
                                <span class="badge bg-warning px-3 py-2">
                                <i class="bi bi-lightning-fill me-1"></i>Avançado
                            </span>
                            @else
                                <span class="badge bg-primary px-3 py-2">
                                <i class="bi bi-graph-up me-1"></i>Intermediário
                            </span>
                            @endif
                        </div>

                        <h1 class="display-5 fw-bold mb-3">
                            {{ $course->title ?? 'Desenvolvimento Web Completo com Laravel' }}
                        </h1>

                        <p class="lead mb-4">
                            {{ $course->subtitle ?? 'Aprenda a desenvolver aplicações web modernas e escaláveis usando o framework Laravel com PHP, MySQL e as melhores práticas do mercado.' }}
                        </p>

                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="bi bi-people-fill display-6 mb-2"></i>
                                    <h5 class="fw-bold mb-0">{{ $course->enrolled_count ?? '1,247' }}</h5>
                                    <small>Alunos Matriculados</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="bi bi-clock-fill display-6 mb-2"></i>
                                    <h5 class="fw-bold mb-0">{{ $course->duration ?? '45h' }}</h5>
                                    <small>Duração Total</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="bi bi-play-circle-fill display-6 mb-2"></i>
                                    <h5 class="fw-bold mb-0">{{ $course->lessons_count ?? '120' }}</h5>
                                    <small>Aulas Práticas</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="bi bi-star-fill display-6 mb-2"></i>
                                    <h5 class="fw-bold mb-0">{{ $course->rating ?? '4.8' }}</h5>
                                    <small>Avaliação Média</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-lg border-0" style="border-radius: 20px;">
                        <img src="{{ $course->image_url ?? asset('web/img/webp/no-image-available-1by1.webp') }}"
                             class="card-img-top"
                             alt="{{ $course->title ?? 'Curso' }}"
                             style="height: 250px; object-fit: cover; border-radius: 20px 20px 0 0;">

                        <div class="card-body p-4">
                            @if(($course->price ?? 0) > 0)
                                <div class="text-center mb-3">
                                    <h3 class="text-primary fw-bold mb-1">
                                        R$ {{ number_format($course->price ?? 297.90, 2, ',', '.') }}
                                    </h3>
                                    @if(isset($course->original_price) && $course->original_price > $course->price)
                                        <p class="text-muted mb-0">
                                            <small class="text-decoration-line-through">
                                                R$ {{ number_format($course->original_price, 2, ',', '.') }}
                                            </small>
                                            <span class="badge bg-success ms-2">
                                            {{ round((($course->original_price - $course->price) / $course->original_price) * 100) }}% OFF
                                        </span>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="text-center mb-3">
                                    <h3 class="text-success fw-bold">Gratuito</h3>
                                </div>
                            @endif

                            <div class="d-grid gap-2 mb-3">
                                @guest
                                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#enrollModal">
                                        <i class="bi bi-cart-plus me-2"></i>Matricular-se Agora
                                    </button>
                                    @if($demoLesson)
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#demoModal">
                                            <i class="bi bi-play-circle me-2"></i>Aula Demonstrativa
                                        </button>
                                    @else
                                        <button class="btn btn-outline-secondary" disabled>
                                            <i class="bi bi-play-circle me-2"></i>Sem Aula Demonstrativa
                                        </button>
                                    @endif
                                @else
                                    @if(isset($isEnrolled) && $isEnrolled)
                                        <a href="{{ route('student.courses') }}" class="btn btn-success btn-lg">
                                            <i class="bi bi-play-fill me-2"></i>Continuar Estudando
                                        </a>
                                    @else
                                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#enrollModal">
                                            <i class="bi bi-cart-plus me-2"></i>Matricular-se Agora
                                        </button>
                                    @endif
                                    @if($demoLesson)
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#demoModal">
                                            <i class="bi bi-play-circle me-2"></i>Aula Demonstrativa
                                        </button>
                                    @else
                                        <button class="btn btn-outline-secondary" disabled>
                                            <i class="bi bi-play-circle me-2"></i>Sem Aula Demonstrativa
                                        </button>
                                    @endif
                                @endguest
                            </div>

                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Garantia de 30 dias ou seu dinheiro de volta
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
                    <!-- Course Navigation -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <ul class="nav nav-pills justify-content-center" id="courseNav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
                                        <i class="bi bi-info-circle me-2"></i>Visão Geral
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="curriculum-tab" data-bs-toggle="pill" data-bs-target="#curriculum" type="button" role="tab">
                                        <i class="bi bi-list-ul me-2"></i>Conteúdo
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="instructor-tab" data-bs-toggle="pill" data-bs-target="#instructor" type="button" role="tab">
                                        <i class="bi bi-person me-2"></i>Instrutor
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button" role="tab">
                                        <i class="bi bi-star me-2"></i>Avaliações
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="courseNavContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="fw-bold mb-4">Sobre este curso</h3>
                                    <div class="mb-4">
                                        <p class="lead">
                                            {{ $course->description ?? 'Este curso abrangente de desenvolvimento web com Laravel foi criado para levar você do básico ao avançado, fornecendo todas as habilidades necessárias para construir aplicações web modernas e escaláveis.' }}
                                        </p>
                                    </div>

                                    <h4 class="fw-bold mb-3">O que você vai aprender</h4>
                                    <div class="row">
                                        @php
                                            $learningOutcomes = $course->learning_outcomes ?? [
                                                'Fundamentos do PHP e orientação a objetos',
                                                'Laravel Framework completo do básico ao avançado',
                                                'Desenvolvimento de APIs RESTful',
                                                'Autenticação e autorização de usuários',
                                                'Trabalhar com bancos de dados MySQL',
                                                'Deploy de aplicações em produção',
                                                'Testes unitários e de integração',
                                                'Boas práticas de desenvolvimento'
                                            ];
                                        @endphp

                                        <div class="col-md-6">
                                            @foreach(array_slice($learningOutcomes, 0, 4) as $outcome)
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                                    <span>{{ $outcome }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            @foreach(array_slice($learningOutcomes, 4) as $outcome)
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                                    <span>{{ $outcome }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <h4 class="fw-bold mb-3 mt-4">Pré-requisitos</h4>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        {{ $course->prerequisites ?? 'Conhecimentos básicos de HTML, CSS e lógica de programação são recomendados, mas não obrigatórios. O curso é projetado para iniciantes.' }}
                                    </div>

                                    <h4 class="fw-bold mb-3">Tecnologias que você vai dominar</h4>
                                    <div class="d-flex flex-wrap gap-2">
                                        @php
                                            $technologies = $course->technologies ?? ['PHP', 'Laravel', 'MySQL', 'HTML5', 'CSS3', 'JavaScript', 'Bootstrap', 'Git'];
                                        @endphp
                                        @foreach($technologies as $tech)
                                            <span class="badge bg-primary px-3 py-2 fs-6">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Curriculum Tab -->
                        <div class="tab-pane fade" id="curriculum" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="fw-bold mb-4">Conteúdo do Curso</h3>

                                    @php
                                        $modules = $course->modules ?? [
                                            [
                                                'title' => 'Introdução ao Desenvolvimento Web',
                                                'lessons' => [
                                                    'Configuração do ambiente de desenvolvimento',
                                                    'Introdução ao PHP',
                                                    'Conceitos básicos de orientação a objetos',
                                                    'Trabalhando com Composer'
                                                ]
                                            ],
                                            [
                                                'title' => 'Laravel Fundamentals',
                                                'lessons' => [
                                                    'Instalação e configuração do Laravel',
                                                    'Estrutura de pastas e arquitetura MVC',
                                                    'Rotas e Controllers',
                                                    'Views e Blade Templates'
                                                ]
                                            ],
                                            [
                                                'title' => 'Banco de Dados',
                                                'lessons' => [
                                                    'Configuração do banco de dados',
                                                    'Migrations e Schema Builder',
                                                    'Eloquent ORM',
                                                    'Relacionamentos entre modelos'
                                                ]
                                            ],
                                            [
                                                'title' => 'Autenticação e Segurança',
                                                'lessons' => [
                                                    'Sistema de autenticação',
                                                    'Middleware e Guards',
                                                    'Autorização e Políticas',
                                                    'Validação de formulários'
                                                ]
                                            ]
                                        ];
                                    @endphp

                                    <div class="accordion" id="curriculumAccordion">
                                        @foreach($modules as $index => $module)
                                            <div class="accordion-item border-0 mb-3 shadow-sm">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#module{{ $index }}"
                                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary me-3">{{ $index + 1 }}</span>
                                                            <div>
                                                                <h6 class="mb-0">{{ $module['title'] }}</h6>
                                                                <small class="text-muted">{{ count($module['lessons']) }} aulas</small>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="module{{ $index }}"
                                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                                     data-bs-parent="#curriculumAccordion">
                                                    <div class="accordion-body">
                                                        @foreach($module['lessons'] as $lessonIndex => $lesson)
                                                            <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                                <i class="bi bi-play-circle text-primary me-3"></i>
                                                                <div class="flex-grow-1">
                                                                    <span>{{ $lesson['title'] }}</span>
                                                                </div>
                                                                <small class="text-muted">{{ rand(5, 15) }} min</small>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructor Tab -->
                        <div class="tab-pane fade" id="instructor" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="fw-bold mb-4">Seu Instrutor</h3>

                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ Storage::url('public/' . $course->instructor->avatar) }}"
                                                 class="rounded-circle mb-3"
                                                 width="150"
                                                 height="150"
                                                 alt="{{ $course->instructor->name ?? 'Prof. João Silva' }}">
                                        </div>
                                        <div class="col-md-9">
                                            <h4 class="fw-bold">{{ $course->instructor->name ?? 'Prof. João Silva' }}</h4>
                                            <p class="text-primary mb-2">{{ $course->instructor->title ?? 'Desenvolvedor Full Stack Senior' }}</p>

                                            <div class="row text-center mb-3">
                                                <div class="col-3">
                                                    <h5 class="fw-bold text-primary mb-0">{{ $course->instructor->courses_count ?? '12' }}</h5>
                                                    <small class="text-muted">Cursos</small>
                                                </div>
                                                <div class="col-3">
                                                    <h5 class="fw-bold text-primary mb-0">{{ $course->instructor->students_count ?? '5,247' }}</h5>
                                                    <small class="text-muted">Alunos</small>
                                                </div>
                                                <div class="col-3">
                                                    <h5 class="fw-bold text-primary mb-0">{{ $course->instructor->rating ?? '4.9' }}</h5>
                                                    <small class="text-muted">Avaliação</small>
                                                </div>
                                                <div class="col-3">
                                                    <h5 class="fw-bold text-primary mb-0">{{ $course->instructor->experience ?? '8+' }}</h5>
                                                    <small class="text-muted">Anos Exp.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="mb-4">
                                        {{ $course->instructor->bio ?? 'Desenvolvedor Full Stack com mais de 8 anos de experiência em desenvolvimento web. Especialista em Laravel, PHP, JavaScript e tecnologias modernas. Já treinou mais de 5.000 desenvolvedores em todo o Brasil, sempre focando em ensinar através de projetos práticos e reais.' }}
                                    </p>

                                    <h5 class="fw-bold mb-3">Experiência Profissional</h5>
                                    <div class="mb-4">
                                        @php
                                            $experiences = $course->instructor->experiences ?? [
                                                'Tech Lead na Empresa XYZ (2020-atual)',
                                                'Desenvolvedor Senior na StartupABC (2018-2020)',
                                                'Freelancer Full Stack (2016-2018)',
                                                'Desenvolvedor Júnior na WebCorp (2015-2016)'
                                            ];
                                        @endphp
                                        @foreach($experiences as $experience)
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-briefcase text-primary me-3"></i>
                                                <span>{{ $experience }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="fw-bold mb-4">Avaliações dos Alunos</h3>

                                    <!-- Rating Summary -->
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4 text-center">
                                            <h2 class="display-4 fw-bold text-primary">{{ $course->rating ?? '4.8' }}</h2>
                                            <div class="text-warning mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= ($course->rating ?? 4.8))
                                                        <i class="bi bi-star-fill"></i>
                                                    @else
                                                        <i class="bi bi-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="text-muted">{{ $course->reviews_count ?? '247' }} avaliações</p>
                                        </div>
                                        <div class="col-md-8">
                                            @for($i = 5; $i >= 1; $i--)
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="me-2">{{ $i }} <i class="bi bi-star-fill text-warning"></i></span>
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-warning"
                                                             style="width: {{ $i === 5 ? '70' : ($i === 4 ? '20' : ($i === 3 ? '7' : ($i === 2 ? '2' : '1'))) }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $i === 5 ? '70' : ($i === 4 ? '20' : ($i === 3 ? '7' : ($i === 2 ? '2' : '1'))) }}%</small>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    <!-- Individual Reviews -->
                                    <div class="reviews-list">
                                        @php
                                            $reviews = [
                                                [
                                                    'name' => 'Maria Santos',
                                                    'rating' => 5,
                                                    'date' => '2 semanas atrás',
                                                    'comment' => 'Curso excepcional! O instrutor explica de forma muito clara e os exercícios práticos realmente ajudam a fixar o conteúdo. Recomendo para qualquer pessoa que queira aprender Laravel.',
                                                    'avatar' => env('APP_URL') . '/web/img/webp/no-avatar-available.webp'
                                                ],
                                                [
                                                    'name' => 'Carlos Oliveira',
                                                    'rating' => 5,
                                                    'date' => '1 mês atrás',
                                                    'comment' => 'Melhor investimento que fiz em educação. Consegui uma promoção no trabalho depois de aplicar os conhecimentos aprendidos neste curso.',
                                                    'avatar' => env('APP_URL') . '/web/img/webp/no-avatar-available.webp'
                                                ],
                                                [
                                                    'name' => 'Ana Silva',
                                                    'rating' => 4,
                                                    'date' => '1 mês atrás',
                                                    'comment' => 'Curso muito bom, conteúdo atualizado e bem estruturado. Único ponto a melhorar seria ter mais exercícios práticos nos primeiros módulos.',
                                                    'avatar' => env('APP_URL') . '/web/img/webp/no-avatar-available.webp'
                                                ]
                                            ];
                                        @endphp

                                        @foreach($reviews as $review)
                                            <div class="border-bottom pb-4 mb-4">
                                                <div class="d-flex align-items-start">
                                                    <img src="{{ $review['avatar'] }}"
                                                         class="rounded-circle me-3"
                                                         width="50"
                                                         height="50"
                                                         alt="{{ $review['name'] }}">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <h6 class="fw-bold mb-0">{{ $review['name'] }}</h6>
                                                            <small class="text-muted">{{ $review['date'] }}</small>
                                                        </div>
                                                        <div class="text-warning mb-2">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review['rating'])
                                                                    <i class="bi bi-star-fill"></i>
                                                                @else
                                                                    <i class="bi bi-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <p class="mb-0">{{ $review['comment'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-down me-2"></i>Carregar Mais Avaliações
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Course Features -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Este curso inclui:
                            </h5>

                            @php
                                $features = [
                                    ['icon' => 'bi-play-circle', 'text' => ($course->duration ?? '45') . ' horas de vídeo sob demanda'],
                                    ['icon' => 'bi-file-earmark-text', 'text' => ($course->resources_count ?? '25') . ' recursos para download'],
                                    ['icon' => 'bi-infinity', 'text' => 'Acesso vitalício completo'],
                                    ['icon' => 'bi-phone', 'text' => 'Acesso no celular e TV'],
                                    ['icon' => 'bi-award', 'text' => 'Certificado de conclusão'],
                                    ['icon' => 'bi-arrow-clockwise', 'text' => 'Garantia de reembolso de 30 dias']
                                ];
                            @endphp

                            @foreach($features as $feature)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi {{ $feature['icon'] }} text-primary me-3"></i>
                                    <span>{{ $feature['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Related Courses -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Cursos Relacionados</h5>

                            @foreach($relatedCourses as $relatedCourse)
                                <div class="d-flex align-items-center mb-3">
                                    @if($relatedCourse->image_url)
                                    <img src="{{ $relatedCourse->image_url }}"
                                         class="rounded me-3"
                                         width="80"
                                         height="60"
                                         alt="{{ $relatedCourse->title }}">
                                         @elseif($relatedCourse->image_url == null)
                                         <img src="{{ asset('web/img/webp/no-image-available-1by1.webp') }}"
                                         class="rounded me-3"
                                         width="80"
                                         height="60"
                                         alt="{{ $relatedCourse->title }}">
                                         @endif
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold mb-1">{{ $relatedCourse->title }}</h6>
                                        <div class="text-warning mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $relatedCourse->rating)
                                                    <i class="bi bi-star-fill small"></i>
                                                @else
                                                    <i class="bi bi-star small"></i>
                                                @endif
                                            @endfor
                                            <small class="text-muted ms-1">({{ $relatedCourse->rating }})</small>
                                        </div>
                                        <p class="text-primary fw-bold mb-0">
                                            R$ {{ number_format($relatedCourse->price, 2, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enrollment Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-cart-plus me-2"></i>
                        Matricular-se no Curso
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ $course->image_url }}"
                                 class="mb-3"
                                 style="max-width: 370px; height: 250px; object-fit: cover;"
                                 alt="{{ $course->title ?? 'Curso' }}">
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">{{ $course->title ?? 'Desenvolvimento Web com Laravel' }}</h5>
                            <p class="text-muted">{{ $course->instructor->name ?? 'Prof. João Silva' }}</p>

                            @if(($course->price ?? 0) > 0)
                                <h4 class="text-primary fw-bold mb-3">
                                    R$ {{ number_format($course->price ?? 297.90, 2, ',', '.') }}
                                </h4>
                            @else
                                <h4 class="text-success fw-bold mb-3">Gratuito</h4>
                            @endif

                            <div class="mb-3">
                                <small class="text-muted d-block">Você terá acesso a:</small>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check text-success me-2"></i>{{ $course->duration ?? '45' }} horas de conteúdo</li>
                                    <li><i class="bi bi-check text-success me-2"></i>Certificado de conclusão</li>
                                    <li><i class="bi bi-check text-success me-2"></i>Suporte do instrutor</li>
                                    <li><i class="bi bi-check text-success me-2"></i>Acesso vitalício</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    @guest
                        <a href="{{ route('web.login') }}" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Fazer Login para Continuar
                        </a>
                    @else
                        <button type="button" class="btn btn-primary" onclick="enrollInCourse()">
                            <i class="bi bi-credit-card me-2"></i>Finalizar Matrícula
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Lesson Modal -->
    @if($demoLesson)
        <div class="modal fade" id="demoModal" tabindex="-1" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="demoModalLabel">
                            <i class="bi bi-play-circle me-2"></i>Aula Demonstrativa: {{ $demoLesson->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <!-- Video Player -->
                            <div class="col-lg-8">
                                <div class="ratio ratio-16x9">
                                    @php
                                        $videoUrl = $demoLesson->video_url;
                                        $isYouTube = $videoUrl && (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false);
                                        
                                        if ($isYouTube) {
                                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)?\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                                            $youtubeId = $matches[1] ?? '';
                                            $embedUrl = "https://www.youtube.com/embed/{$youtubeId}?rel=0&modestbranding=1&showinfo=0";
                                        }
                                    @endphp
                                    
                                    @if($videoUrl)
                                        @if($isYouTube && !empty($youtubeId))
                                            <iframe 
                                                class="w-100 p-3" 
                                                src="{{ $embedUrl }}" 
                                                title="Aula Demonstrativa"
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <video class="w-100" controls>
                                                <source src="{{ $videoUrl }}" type="video/mp4">
                                                Seu navegador não suporta o elemento de vídeo.
                                            </video>
                                        @endif
                                    @else
                                        <!-- Fallback video -->
                                        <video class="w-100" controls>
                                            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Lesson Info -->
                            <div class="col-lg-4">
                                <div class="p-4">
                                    <div class="mb-3">
                                        <span class="badge bg-success mb-2">
                                            <i class="bi bi-unlock me-1"></i>Aula Gratuita
                                        </span>
                                        <h6 class="fw-bold">{{ $demoLesson->title }}</h6>
                                        @if($demoLesson->duration)
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>{{ $demoLesson->duration }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    @if($demoLesson->description)
                                        <div class="mb-3">
                                            <h6 class="fw-bold">Descrição:</h6>
                                            <p class="text-muted small">{{ $demoLesson->description }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Módulo:</h6>
                                        <p class="text-muted small mb-0">{{ $demoLesson->module->title ?? 'Não definido' }}</p>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enrollModal" data-bs-dismiss="modal">
                                            <i class="bi bi-cart-plus me-2"></i>Matricular-se Agora
                                        </button>
                                        <small class="text-center text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Esta é apenas uma amostra do conteúdo
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Fechar
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enrollModal" data-bs-dismiss="modal">
                            <i class="bi bi-cart-plus me-2"></i>Quero me Matricular
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .course-item {
            transition: all 0.3s ease;
        }

        .course-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .nav-pills .nav-link {
            border-radius: 50px;
            margin: 0 5px;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .text-warning .bi-star-fill {
            color: #ffc107 !important;
        }

        .text-warning .bi-star {
            color: #dee2e6 !important;
        }
    </style>

    <script>
        function enrollInCourse() {
            // Simulate enrollment process
            alert('Redirecionando para o pagamento...');
            // In a real application, this would redirect to payment gateway
        }

        // Add smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#courseNav button');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Smooth scroll to content after tab change
                    setTimeout(() => {
                        document.getElementById('courseNavContent').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 150);
                });
            });
            
            // Parar vídeo ao fechar modal de demonstração
            const demoModal = document.getElementById('demoModal');
            if (demoModal) {
                demoModal.addEventListener('hidden.bs.modal', function() {
                    // Parar vídeo do YouTube (iframe)
                    const iframe = demoModal.querySelector('iframe');
                    if (iframe) {
                        const src = iframe.src;
                        iframe.src = '';
                        iframe.src = src; // Recarrega o iframe, parando o vídeo
                    }
                    
                    // Parar vídeo HTML5
                    const video = demoModal.querySelector('video');
                    if (video) {
                        video.pause();
                        video.currentTime = 0; // Volta para o início
                    }
                });
            }
        });
    </script>
@endsection
