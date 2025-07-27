@extends('web._theme')

@section('title', 'Cursos - Portal de Cursos')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Nossos Cursos</h1>
                <p class="lead text-muted">Explore nossa ampla variedade de cursos e encontre o perfeito para você.</p>
            </div>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar cursos..." id="searchCourses">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select" id="filterPrice">
                            <option value="">Todos os preços</option>
                            <option value="0-100">Até R$ 100</option>
                            <option value="100-300">R$ 100 - R$ 300</option>
                            <option value="300-500">R$ 300 - R$ 500</option>
                            <option value="500+">Acima de R$ 500</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="filterStatus">
                            <option value="">Todos os status</option>
                            <option value="sim">Disponível</option>
                            <option value="não">Indisponível</option>
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
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Encontrados <span id="courseCount">{{ $courses->count() }}</span> cursos</h3>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="viewMode" id="gridView" checked>
                        <label class="btn btn-outline-secondary" for="gridView"><i class="bi bi-grid-3x3-gap"></i></label>
                        <input type="radio" class="btn-check" name="viewMode" id="listView">
                        <label class="btn btn-outline-secondary" for="listView"><i class="bi bi-list"></i></label>
                    </div>
                </div>
            </div>
        </div>
        
        @if($courses->count() > 0)
            <div id="coursesContainer" class="row">
                @foreach ($courses as $course)
                    <div class="col-lg-4 col-md-6 mb-4 course-item" 
                         data-title="{{ strtolower($course->title) }}" 
                         data-description="{{ strtolower($course->description) }}"
                         data-price="{{ $course->price }}"
                         data-status="{{ $course->status }}">
                        <div class="card course-card h-100 shadow-sm">
                            <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                                <i class="bi bi-mortarboard display-6"></i>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0">{{ $course->title }}</h5>
                                    @if($course->status === 'sim')
                                        <span class="badge bg-success">Disponível</span>
                                    @else
                                        <span class="badge bg-secondary">Indisponível</span>
                                    @endif
                                </div>
                                
                                <p class="card-text text-muted flex-grow-1 mb-3">{{ Str::limit($course->description, 120) }}</p>
                                
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
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('web.course.detail', $course->id) }}" class="btn btn-primary">
                                        <i class="bi bi-eye me-2"></i>Ver Detalhes
                                    </a>
                                    @if($course->status === 'sim' && $course->remaining_slots > 0)
                                        <a href="{{ route('web.course.detail', $course->id) }}" class="btn btn-success">
                                            <i class="bi bi-cart-plus me-2"></i>Inscrever-se
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            <i class="bi bi-x-circle me-2"></i>Indisponível
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- No results message -->
            <div id="noResults" class="text-center py-5" style="display: none;">
                <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3 text-muted">Nenhum curso encontrado</h3>
                <p class="text-muted">Tente ajustar os filtros ou termos de busca.</p>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3 text-muted">Nenhum curso disponível no momento</h3>
                <p class="text-muted">Novos cursos serão adicionados em breve. Fique atento!</p>
            </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h3 class="fw-bold mb-3">Não encontrou o que procurava?</h3>
                <p class="text-muted mb-4">Cadastre-se em nossa newsletter e seja o primeiro a saber sobre novos cursos!</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Seu e-mail">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-envelope me-2"></i>Cadastrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCourses');
    const priceFilter = document.getElementById('filterPrice');
    const statusFilter = document.getElementById('filterStatus');
    const courseItems = document.querySelectorAll('.course-item');
    const courseCount = document.getElementById('courseCount');
    const noResults = document.getElementById('noResults');
    const coursesContainer = document.getElementById('coursesContainer');
    
    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const priceRange = priceFilter.value;
        const statusValue = statusFilter.value;
        let visibleCount = 0;
        
        courseItems.forEach(item => {
            const title = item.dataset.title;
            const description = item.dataset.description;
            const price = parseFloat(item.dataset.price);
            const status = item.dataset.status;
            
            let showItem = true;
            
            // Search filter
            if (searchTerm && !title.includes(searchTerm) && !description.includes(searchTerm)) {
                showItem = false;
            }
            
            // Price filter
            if (priceRange) {
                if (priceRange === '0-100' && price > 100) showItem = false;
                if (priceRange === '100-300' && (price < 100 || price > 300)) showItem = false;
                if (priceRange === '300-500' && (price < 300 || price > 500)) showItem = false;
                if (priceRange === '500+' && price < 500) showItem = false;
            }
            
            // Status filter
            if (statusValue && status !== statusValue) {
                showItem = false;
            }
            
            if (showItem) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        courseCount.textContent = visibleCount;
        
        if (visibleCount === 0) {
            noResults.style.display = 'block';
            coursesContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            coursesContainer.style.display = 'flex';
        }
    }
    
    searchInput.addEventListener('input', filterCourses);
    priceFilter.addEventListener('change', filterCourses);
    statusFilter.addEventListener('change', filterCourses);
    
    // View mode toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    listView.addEventListener('change', function() {
        if (this.checked) {
            courseItems.forEach(item => {
                item.className = 'col-12 mb-3 course-item';
                const card = item.querySelector('.card');
                card.classList.remove('h-100');
                card.classList.add('card-horizontal');
            });
        }
    });
    
    gridView.addEventListener('change', function() {
        if (this.checked) {
            courseItems.forEach(item => {
                item.className = 'col-lg-4 col-md-6 mb-4 course-item';
                const card = item.querySelector('.card');
                card.classList.add('h-100');
                card.classList.remove('card-horizontal');
            });
        }
    });
});
</script>

<style>
.card-horizontal {
    flex-direction: row;
}

.card-horizontal .card-header {
    width: 200px;
    flex-shrink: 0;
}

.card-horizontal .card-body {
    flex: 1;
}

@media (max-width: 768px) {
    .card-horizontal {
        flex-direction: column;
    }
    
    .card-horizontal .card-header {
        width: 100%;
    }
}
</style>
@endsection