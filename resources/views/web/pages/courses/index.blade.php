@extends('web._theme')

@section('title', 'Cursos - Portal de Cursos')

@section('content')
<!-- Header Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center text-center text-white">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-journal-bookmark-fill me-3"></i>
                    Nossos Cursos
                </h1>
                <p class="lead mb-4">
                    Descubra os melhores cursos online e transforme sua carreira com conhecimento de qualidade
                </p>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="fw-bold">{{ $totalCourses ?? '50+' }}</h3>
                            <small>Cursos Disponíveis</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="fw-bold">{{ $totalStudents ?? '1000+' }}</h3>
                            <small>Alunos Ativos</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="fw-bold">4.8/5</h3>
                            <small>Avaliação Média</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Buscar cursos..." id="searchInput">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Todas as Categorias</option>
                            <option value="programacao">Programação</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                            <option value="negocios">Negócios</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="priceFilter">
                            <option value="">Todos os Preços</option>
                            <option value="free">Gratuitos</option>
                            <option value="paid">Pagos</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Grid -->
<section class="py-5">
    <div class="container">
        <div class="row" id="coursesGrid">
            @forelse($courses ?? [] as $course)
                <div class="col-lg-4 col-md-6 mb-4 course-card"
                     data-category="{{ $course->category ?? 'programacao' }}"
                     data-price="{{ $course->price > 0 ? 'paid' : 'free' }}"
                     data-title="{{ strtolower($course->title ?? 'Curso de Exemplo') }}">
                    <div class="card h-100 shadow-sm border-0 course-item">
                        <div class="position-relative">
                            <img src="{{ $course->image ?? asset('web/img/webp/no-image-available-1by1.webp') }}"
                                 class="card-img-top"
                                 alt="{{ $course->title ?? 'Curso' }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if(($course->price ?? 0) == 0)
                                    <span class="badge bg-success">Gratuito</span>
                                @else
                                    <span class="badge bg-primary">Pago</span>
                                @endif
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge bg-dark bg-opacity-75">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ $course->enrolled_count ?? rand(50, 500) }} alunos
                                </span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($course->category ?? 'Programação') }}
                                </span>
                            </div>
                            <h5 class="card-title">{{ $course->title ?? 'Curso de Desenvolvimento Web' }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($course->description ?? 'Aprenda as principais tecnologias do mercado com instrutores experientes e material atualizado.', 100) }}
                            </p>
                            <div class="row align-items-center mb-3">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $course->instructor->avatar ?? 'https://via.placeholder.com/30x30/667eea/ffffff?text=I' }}"
                                             class="rounded-circle me-2"
                                             width="30"
                                             height="30"
                                             alt="Instrutor">
                                        <small class="text-muted">{{ $course->instructor->name ?? 'Prof. Silva' }}</small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($course->rating ?? 4.5))
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted ms-1">({{ $course->reviews_count ?? rand(10, 100) }})</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    @if(($course->price ?? 0) > 0)
                                        <h5 class="text-primary mb-0">
                                            R$ {{ number_format($course->price ?? 299.90, 2, ',', '.') }}
                                        </h5>
                                        @if(isset($course->original_price) && $course->original_price > $course->price)
                                            <small class="text-muted text-decoration-line-through">
                                                R$ {{ number_format($course->original_price, 2, ',', '.') }}
                                            </small>
                                        @endif
                                    @else
                                        <h5 class="text-success mb-0">Gratuito</h5>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('web.courses.details', $course->id ?? 1) }}"
                                       class="btn btn-primary btn-sm">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Cursos de exemplo caso não haja dados -->
                @for($i = 1; $i <= 9; $i++)
                    <div class="col-lg-4 col-md-6 mb-4 course-card"
                         data-category="programacao"
                         data-price="paid"
                         data-title="curso de exemplo {{ $i }}">
                        <div class="card h-100 shadow-sm border-0 course-item">
                            <div class="position-relative">
                                <img src="https://via.placeholder.com/350x200/667eea/ffffff?text=Curso+{{ $i }}"
                                     class="card-img-top"
                                     alt="Curso {{ $i }}"
                                     style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary">Pago</span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75">
                                        <i class="bi bi-people-fill me-1"></i>
                                        {{ rand(50, 500) }} alunos
                                    </span>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">Programação</span>
                                </div>
                                <h5 class="card-title">Curso de Desenvolvimento Web {{ $i }}</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    Aprenda as principais tecnologias do mercado com instrutores experientes e material sempre atualizado.
                                </p>
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/30x30/667eea/ffffff?text=I"
                                                 class="rounded-circle me-2"
                                                 width="30"
                                                 height="30"
                                                 alt="Instrutor">
                                            <small class="text-muted">Prof. Silva</small>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <small class="text-muted ms-1">({{ rand(10, 100) }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="text-primary mb-0">
                                            R$ {{ number_format(rand(199, 599), 2, ',', '.') }}
                                        </h5>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('web.courses.details', $i) }}"
                                           class="btn btn-primary btn-sm">
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5 d-none">
            <i class="bi bi-search display-1 text-muted"></i>
            <h3 class="mt-3">Nenhum curso encontrado</h3>
            <p class="text-muted">Tente ajustar os filtros ou buscar por outros termos.</p>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary btn-lg" id="loadMore">
                <i class="bi bi-arrow-down-circle me-2"></i>
                Carregar Mais Cursos
            </button>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Não encontrou o que procurava?</h2>
                <p class="lead text-muted mb-4">
                    Entre em contato conosco e solicite um curso personalizado para suas necessidades
                </p>
                <a href="{{ route('web.contact') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-envelope me-2"></i>
                    Solicitar Curso
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.course-item {
    transition: all 0.3s ease;
}

.course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.course-card {
    transition: all 0.3s ease;
}

.card-img-top {
    transition: all 0.3s ease;
}

.course-item:hover .card-img-top {
    transform: scale(1.05);
}

.badge {
    font-size: 0.75rem;
}

.text-warning .bi-star-fill {
    color: #ffc107 !important;
}

.text-warning .bi-star {
    color: #dee2e6 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceFilter = document.getElementById('priceFilter');
    const coursesGrid = document.getElementById('coursesGrid');
    const noResults = document.getElementById('noResults');
    const loadMoreBtn = document.getElementById('loadMore');

    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const selectedPrice = priceFilter.value;
        const courseCards = document.querySelectorAll('.course-card');
        let visibleCount = 0;

        courseCards.forEach(card => {
            const title = card.dataset.title;
            const category = card.dataset.category;
            const price = card.dataset.price;

            const matchesSearch = !searchTerm || title.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            const matchesPrice = !selectedPrice || price === selectedPrice;

            if (matchesSearch && matchesCategory && matchesPrice) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
            loadMoreBtn.style.display = 'none';
        } else {
            noResults.classList.add('d-none');
            loadMoreBtn.style.display = 'block';
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterCourses);
    categoryFilter.addEventListener('change', filterCourses);
    priceFilter.addEventListener('change', filterCourses);

    // Load more functionality (placeholder)
    loadMoreBtn.addEventListener('click', function() {
        // Aqui você pode implementar o carregamento de mais cursos via AJAX
        alert('Funcionalidade de carregar mais cursos será implementada!');
    });
});
</script>
@endsection
