@extends('web._theme')

@section('title', 'Sobre Nós - Portal de Cursos')

@section('content')
<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white mb-4">Sobre o Portal de Cursos</h1>
                <p class="lead text-white-75 mb-4">Somos uma plataforma dedicada a transformar vidas através da educação online de qualidade, conectando estudantes aos melhores instrutores e conteúdos do mercado.</p>
                <a href="#mission" class="btn btn-light btn-lg">Conheça Nossa Missão</a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-mortarboard-fill text-white opacity-75" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section id="mission" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-4">Nossa Missão</h2>
                <p class="lead text-muted">Democratizar o acesso à educação de qualidade, oferecendo cursos online que capacitam pessoas a alcançarem seus objetivos profissionais e pessoais.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-target text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Missão</h4>
                    <p class="text-muted">Transformar vidas através da educação online acessível e de qualidade, capacitando pessoas para o mercado de trabalho.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-eye text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Visão</h4>
                    <p class="text-muted">Ser a principal plataforma de educação online do Brasil, reconhecida pela excelência e inovação em ensino.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-heart text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="fw-bold">Valores</h4>
                    <p class="text-muted">Qualidade, acessibilidade, inovação, transparência e compromisso com o sucesso dos nossos estudantes.</p>
                </div>
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
                        <h3 class="fw-bold">10.000+</h3>
                        <p class="text-muted">Estudantes Formados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-book-fill text-success display-4 mb-3"></i>
                        <h3 class="fw-bold">150+</h3>
                        <p class="text-muted">Cursos Disponíveis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-person-check-fill text-warning display-4 mb-3"></i>
                        <h3 class="fw-bold">50+</h3>
                        <p class="text-muted">Instrutores Especialistas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <i class="bi bi-calendar-check-fill text-info display-4 mb-3"></i>
                        <h3 class="fw-bold">5+</h3>
                        <p class="text-muted">Anos de Experiência</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">Nossa Equipe</h2>
                <p class="lead text-muted">Conheça os profissionais dedicados que tornam possível a excelência do Portal de Cursos.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold" style="font-size: 2rem;">AS</span>
                        </div>
                        <h5 class="fw-bold">Ana Silva</h5>
                        <p class="text-muted mb-3">CEO & Fundadora</p>
                        <p class="small text-muted">Especialista em educação com mais de 15 anos de experiência em desenvolvimento de plataformas educacionais.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold" style="font-size: 2rem;">CS</span>
                        </div>
                        <h5 class="fw-bold">Carlos Santos</h5>
                        <p class="text-muted mb-3">CTO</p>
                        <p class="small text-muted">Engenheiro de software com expertise em desenvolvimento de plataformas escaláveis e tecnologias educacionais.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold" style="font-size: 2rem;">MO</span>
                        </div>
                        <h5 class="fw-bold">Maria Oliveira</h5>
                        <p class="text-muted mb-3">Diretora Pedagógica</p>
                        <p class="small text-muted">Pedagoga com mestrado em educação digital, responsável pela qualidade e metodologia dos nossos cursos.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Nossa História</h2>
                
                <div class="timeline">
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 60px; height: 60px;">
                                2019
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold">Fundação</h5>
                                    <p class="text-muted mb-0">O Portal de Cursos foi fundado com a missão de democratizar o acesso à educação de qualidade através da tecnologia.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 60px; height: 60px;">
                                2020
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold">Expansão</h5>
                                    <p class="text-muted mb-0">Lançamento de mais de 50 cursos em diversas áreas e alcance de 1.000 estudantes ativos na plataforma.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 60px; height: 60px;">
                                2022
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold">Reconhecimento</h5>
                                    <p class="text-muted mb-0">Premiação como "Melhor Plataforma de Educação Online" e parceria com grandes empresas do setor.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 60px; height: 60px;">
                                2024
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold">Inovação</h5>
                                    <p class="text-muted mb-0">Lançamento de novas funcionalidades com IA e realidade virtual, revolucionando a experiência de aprendizado online.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-3">O que nossos estudantes dizem</h2>
                <p class="lead text-muted">Depoimentos reais de quem transformou sua carreira conosco.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-3">"Os cursos do Portal transformaram minha carreira. Consegui uma promoção logo após concluir o curso de gestão de projetos!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">JS</span>
                            </div>
                            <div>
                                <h6 class="mb-0">João Silva</h6>
                                <small class="text-muted">Gerente de Projetos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-3">"Plataforma incrível! O suporte é excepcional e os instrutores são muito qualificados. Recomendo a todos!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">MS</span>
                            </div>
                            <div>
                                <h6 class="mb-0">Maria Santos</h6>
                                <small class="text-muted">Desenvolvedora</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-3">"Flexibilidade total para estudar no meu ritmo. Consegui conciliar trabalho e estudos perfeitamente!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">PR</span>
                            </div>
                            <div>
                                <h6 class="mb-0">Pedro Rodrigues</h6>
                                <small class="text-muted">Analista de Marketing</small>
                            </div>
                        </div>
                    </div>
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
                <h2 class="display-5 fw-bold mb-3">Faça parte da nossa história</h2>
                <p class="lead mb-4">Junte-se a milhares de estudantes que já transformaram suas vidas com nossos cursos.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('web.home') }}" class="btn btn-light btn-lg">Ver Cursos</a>
                    <a href="#" class="btn btn-outline-light btn-lg">Fale Conosco</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection