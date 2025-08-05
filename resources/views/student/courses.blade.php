@extends('student.layouts.dashboard')

@section('title', 'Meus Cursos - Portal de Cursos')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Meus Cursos</h2>
                    <p class="text-muted mb-0">Gerencie suas matrículas e explore novos cursos</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchCoursesModal">
                        <i class="bi bi-search me-2"></i>Buscar Cursos
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <div id="alertContainer"></div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-2">
                        <i class="bi bi-book text-primary fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $enrolledCourses->count() }}</h4>
                    <small class="text-muted">Cursos Matriculados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-2">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $enrolledCourses->where('progress', 100)->count() }}</h4>
                    <small class="text-muted">Cursos Concluídos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stat-icon bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-2">
                        <i class="bi bi-clock text-warning fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $enrolledCourses->where('progress', '<', 100)->count() }}</h4>
                    <small class="text-muted">Em Progresso</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stat-icon bg-info bg-opacity-10 rounded-circle p-3 mx-auto mb-2">
                        <i class="bi bi-star text-info fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $availableCourses->count() }}</h4>
                    <small class="text-muted">Disponíveis</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card stats-card">
                <div class="card-body">
                    <ul class="nav nav-pills" id="courseFilter" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="enrolled-tab" data-bs-toggle="pill" data-bs-target="#enrolled" type="button" role="tab">
                                <i class="bi bi-bookmark-fill me-2"></i>Meus Cursos ({{ $enrolledCourses->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="progress-tab" data-bs-toggle="pill" data-bs-target="#progress" type="button" role="tab">
                                <i class="bi bi-play-circle me-2"></i>Em Andamento ({{ $enrolledCourses->where('progress', '<', 100)->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                                <i class="bi bi-check-circle me-2"></i>Concluídos ({{ $enrolledCourses->where('progress', 100)->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="available-tab" data-bs-toggle="pill" data-bs-target="#available" type="button" role="tab">
                                <i class="bi bi-grid me-2"></i>Disponíveis ({{ $availableCourses->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="featured-tab" data-bs-toggle="pill" data-bs-target="#featured" type="button" role="tab">
                                <i class="bi bi-star me-2"></i>Em Destaque ({{ $featuredCourses->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="tab-content" id="courseFilterContent">
        <!-- Enrolled Courses -->
        <div class="tab-pane fade show active" id="enrolled" role="tabpanel">
            @if($enrolledCourses->count() > 0)
                <div class="row">
                    @foreach($enrolledCourses as $course)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card stats-card h-100">
                                <div class="position-relative">
                                    <img src="{{ $course->image_url ?? asset('/web/img/webp/no-image-available-16by9.webp') }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        @if($course->pivot->progress ?? 0 == 100)
                                            <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Concluído
                                    </span>
                                        @else
                                            <span class="badge bg-primary">
                                        <i class="bi bi-play-circle me-1"></i>Em Andamento
                                    </span>
                                        @endif
                                    </div>
                                    @if($course->pivot->has_certificate ?? false)
                                        <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-warning">
                                        <i class="bi bi-award me-1"></i>Certificado
                                    </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-2">{{ $course->title }}</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-person me-1"></i>{{ $course->instructor->name ?? 'Instrutor não informado' }}
                                    </p>

                                    <!-- Progress Bar -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Progresso</small>
                                            <small class="fw-semibold">{{ $course->pivot->progress ?? 0 }}%</small>
                                        </div>
                                        <div class="course-progress">
                                            <div class="progress-bar {{ ($course->pivot->progress ?? 0) == 100 ? 'bg-success' : '' }}" style="width: {{ $course->pivot->progress ?? 0 }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Course Info -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <small class="text-muted d-block">Duração</small>
                                            <strong>{{ $course->duration ?? 'N/A' }}</strong>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block">Nível</small>
                                            <strong>{{ $course->difficulty_level_label }}</strong>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block">Último acesso</small>
                                            <strong class="small">{{ $course->pivot->last_accessed ?? 'Nunca' }}</strong>
                                        </div>
                                    </div>

                                    @if(($course->pivot->progress ?? 0) < 100 && $course->pivot->next_lesson)
                                        <div class="alert alert-primary alert-sm mb-3">
                                            <small>
                                                <i class="bi bi-play-circle me-1"></i>
                                                <strong>Próxima:</strong> {{ $course->pivot->next_lesson }}
                                            </small>
                                        </div>
                                    @elseif(($course->pivot->progress ?? 0) == 100)
                                        <div class="alert alert-success alert-sm mb-3">
                                            <small>
                                                <i class="bi bi-check-circle me-1"></i>
                                                <strong>Curso concluído!</strong> Parabéns!
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer bg-transparent border-0">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('student.course.detail', $course->id) }}" class="btn btn-outline-primary flex-fill">
                                            <i class="bi bi-eye me-1"></i>Assistir
                                        </a>
                                        @if(($course->pivot->progress ?? 0) < 100 && $course->pivot->next_lesson)
                                            <a href="{{ route('student.course.detail', $course->id) }}#continue" class="btn btn-primary flex-fill">
                                                <i class="bi bi-play-fill me-1"></i>Continuar
                                            </a>
                                        @endif
                                        @if(($course->pivot->progress ?? 0) == 100)
                                            <button class="btn btn-outline-primary flex-fill" onclick="reviewCourse({{ $course->id }})">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Revisar
                                            </button>
                                            @if($course->pivot->has_certificate ?? false)
                                                <button class="btn btn-success flex-fill" onclick="downloadCertificate({{ $course->id }})">
                                                    <i class="bi bi-download me-1"></i>Certificado
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-outline-secondary" onclick="toggleFavorite({{ $course->id }})">
                                                <i class="bi bi-heart{{ $course->pivot->is_favorite ?? false ? '-fill' : '' }}"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book fs-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Nenhum curso matriculado</h5>
                    <p class="text-muted">Explore nossos cursos disponíveis e comece sua jornada de aprendizado!</p>
                    <button class="btn btn-primary" onclick="document.getElementById('available-tab').click()">
                        Explorar Cursos
                    </button>
                </div>
            @endif
        </div>

        <!-- In Progress Courses -->
        <div class="tab-pane fade" id="progress" role="tabpanel">
            <div class="row">
                @foreach($enrolledCourses->where('pivot.progress', '<', 100) as $course)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card stats-card h-100">
                            <div class="position-relative">
                                <img src="{{ $course->image_url ?? asset('/web/img/webp/no-image-available-16by9.webp') }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-primary">
                                <i class="bi bi-play-circle me-1"></i>Em Andamento
                            </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2">{{ $course->title }}</h5>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-person me-1"></i>{{ $course->instructor->name ?? 'Instrutor não informado' }}
                                </p>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">Progresso</small>
                                        <small class="fw-semibold">{{ $course->pivot->progress ?? 0 }}%</small>
                                    </div>
                                    <div class="course-progress">
                                        <div class="progress-bar" style="width: {{ $course->pivot->progress ?? 0 }}%"></div>
                                    </div>
                                </div>

                                @if($course->pivot->next_lesson)
                                    <div class="alert alert-primary alert-sm mb-3">
                                        <small>
                                            <i class="bi bi-play-circle me-1"></i>
                                            <strong>Próxima:</strong> {{ $course->pivot->next_lesson }}
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary flex-fill" onclick="continueCourse({{ $course->id }})">
                                        <i class="bi bi-play-fill me-1"></i>Continuar
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="toggleFavorite({{ $course->id }})">
                                        <i class="bi bi-heart{{ $course->pivot->is_favorite ?? false ? '-fill' : '' }}"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Completed Courses -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="row">
                @foreach($enrolledCourses->where('pivot.progress', 100) as $course)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card stats-card h-100">
                            <div class="position-relative">
                                <img src="{{ $course->image_url ?? asset('/web/img/webp/no-image-available-16by9.webp') }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Concluído
                            </span>
                                </div>
                                @if($course->pivot->has_certificate ?? false)
                                    <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning">
                                    <i class="bi bi-award me-1"></i>Certificado
                                </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2">{{ $course->title }}</h5>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-person me-1"></i>{{ $course->instructor->name ?? 'Instrutor não informado' }}
                                </p>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">Progresso</small>
                                        <small class="fw-semibold text-success">100%</small>
                                    </div>
                                    <div class="course-progress">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div class="alert alert-success alert-sm mb-3">
                                    <small>
                                        <i class="bi bi-check-circle me-1"></i>
                                        <strong>Curso concluído!</strong> Parabéns!
                                    </small>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary flex-fill" onclick="reviewCourse({{ $course->id }})">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Revisar
                                    </button>
                                    @if($course->pivot->has_certificate ?? false)
                                        <button class="btn btn-success flex-fill" onclick="downloadCertificate({{ $course->id }})">
                                            <i class="bi bi-download me-1"></i>Certificado
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Available Courses Tab -->
        <div class="tab-pane fade" id="available" role="tabpanel">
            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" id="filterLevel">
                        <option value="">Todos os níveis</option>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterPrice">
                        <option value="">Todos os preços</option>
                        <option value="free">Gratuito</option>
                        <option value="0-50">R$ 0 - R$ 50</option>
                        <option value="50-100">R$ 50 - R$ 100</option>
                        <option value="100+">R$ 100+</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar por título ou instrutor..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" id="coursesGrid">
                @foreach($availableCourses as $course)
                    <div class="col-lg-6 col-xl-4 mb-4 course-item"
                         data-level="{{ $course->difficulty_level }}"
                         data-price="{{ $course->price }}"
                         data-title="{{ strtolower($course->title) }}"
                         data-instructor="{{ strtolower($course->instructor->name ?? '') }}">
                        <div class="card stats-card h-100">
                            <div class="position-relative">
                                <img src="{{ $course->image_url ?? asset('/web/img/webp/no-image-available-16by9.webp') }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                @if($course->is_featured)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                    <i class="bi bi-star-fill me-1"></i>Destaque
                                </span>
                                @endif
                                <span class="badge bg-{{ $course->status_color }} position-absolute top-0 end-0 m-2">
                                {{ $course->status_label }}
                            </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->description, 100) }}</p>

                                @if($course->instructor)
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>{{ $course->instructor->name }}
                                        </small>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $course->duration ?? 'N/A' }}
                                    </small>
                                    <span class="badge bg-{{ $course->difficulty_level === 'iniciante' ? 'info' : ($course->difficulty_level === 'intermediario' ? 'warning' : 'danger') }}">
                                    {{ $course->difficulty_level_label }}
                                </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="price">
                                        @if($course->price == 0)
                                            <span class="fw-bold text-success">Gratuito</span>
                                        @else
                                            <span class="fw-bold text-primary">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $course->remaining_slots }} vagas
                                    </small>
                                </div>

                                <div class="d-grid mt-auto">
                                    @if($course->isRegistrationOpen())
                                        <button class="btn btn-primary" onclick="enrollCourse({{ $course->id }})">
                                            <i class="bi bi-plus-circle me-2"></i>Matricular-se
                                        </button>
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
        </div>

        <!-- Featured Courses Tab -->
        <div class="tab-pane fade" id="featured" role="tabpanel">
            <div class="row">
                @foreach($featuredCourses as $course)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card stats-card h-100">
                            <div class="position-relative">
                                <img src="{{ $course->image_url ?? asset('/web/img/webp/no-image-available-16by9.webp') }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                <i class="bi bi-star-fill me-1"></i>Destaque
                            </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->description, 100) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $course->rating >= $i ? '-fill' : '' }} text-warning"></i>
                                        @endfor
                                        <small class="text-muted ms-1">({{ $course->total_reviews }})</small>
                                    </div>
                                    <small class="text-muted">{{ $course->total_students }} alunos</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="price">
                                        @if($course->price == 0)
                                            <span class="fw-bold text-success">Gratuito</span>
                                        @else
                                            <span class="fw-bold text-primary">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <span class="badge bg-{{ $course->difficulty_level === 'iniciante' ? 'info' : ($course->difficulty_level === 'intermediario' ? 'warning' : 'danger') }}">
                                    {{ $course->difficulty_level_label }}
                                </span>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('student.course.detail', $course->id) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i>Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
       // Função para matricular em curso
function enrollCourse(courseId) {
    if (confirm('Deseja realmente se matricular neste curso?')) {

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = `/student/courses/${courseId}/enroll`;

        console.log(`Enrolling in course ID: ${courseId}`);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Erro ao realizar matrícula.', 'danger');
            });
    }
}

        // Função para continuar curso
        function continueCourse(courseId) {
            // Implementar navegação para a próxima aula
            window.location.href = `/student/courses/${courseId}/lesson`;
        }

        // Função para revisar curso
        function reviewCourse(courseId) {
            // Implementar navegação para revisão do curso
            window.location.href = `/student/courses/${courseId}/review`;
        }

        // Função para baixar certificado
        function downloadCertificate(courseId) {
            window.location.href = `/student/certificates/${courseId}/download`;
        }

        // Função para toggle favorito
        function toggleFavorite(courseId) {
            fetch(`/student/courses/${courseId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        // Atualizar ícone do coração
                        location.reload();
                    }
                });
        }

        // Filtros
        document.getElementById('filterLevel').addEventListener('change', filterCourses);
        document.getElementById('filterPrice').addEventListener('change', filterCourses);
        document.getElementById('searchInput').addEventListener('input', filterCourses);

        function filterCourses() {
            const level = document.getElementById('filterLevel').value;
            const price = document.getElementById('filterPrice').value;
            const search = document.getElementById('searchInput').value.toLowerCase();

            const courses = document.querySelectorAll('.course-item');

            courses.forEach(course => {
                let show = true;

                // Filter by level
                if (level && course.dataset.level !== level) {
                    show = false;
                }

                // Filter by price
                if (price && show) {
                    const coursePrice = parseFloat(course.dataset.price);

                    if (price === 'free' && coursePrice !== 0) show = false;
                    else if (price === '0-50' && (coursePrice < 0 || coursePrice > 50)) show = false;
                    else if (price === '50-100' && (coursePrice < 50 || coursePrice > 100)) show = false;
                    else if (price === '100+' && coursePrice < 100) show = false;
                }

                // Filter by search
                if (search && show) {
                    const title = course.dataset.title;
                    const instructor = course.dataset.instructor;

                    if (!title.includes(search) && !instructor.includes(search)) {
                        show = false;
                    }
                }

                course.style.display = show ? 'block' : 'none';
            });
        }

        // Função para mostrar alertas
        function showAlert(message, type = 'info') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            alertContainer.appendChild(alert);

            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 5000);
        }
    </script>

    <style>
        .course-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .course-progress .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .course-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .alert-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
