@extends('student.layouts.dashboard')

@section('title', $course->title . ' - Detalhes do Curso')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">{{ $course->title }}</h2>
        <p class="text-muted">{{ $course->description }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card stats-card mb-4">
            <div class="card-body">
                <div class="ratio ratio-16x9 mb-3">
                    <!-- Player de vídeo -->
                    @php
                        $videoUrl = $modules->first()?->lessons->first()?->video_url ?? '';
                        $isYouTube = strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false;
                        
                        if ($isYouTube) {
                            // Extrair ID do vídeo do YouTube
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                            $youtubeId = $matches[1] ?? '';
                            $embedUrl = "https://www.youtube.com/embed/{$youtubeId}?rel=0&modestbranding=1&showinfo=0";
                        }
                    @endphp
                    
                    @if($isYouTube && !empty($youtubeId))
                        <!-- Player do YouTube -->
                        <iframe 
                            id="mainVideo"
                            class="w-100 rounded" 
                            src="{{ $embedUrl }}" 
                            title="Vídeo da Lição"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <!-- Player HTML5 para outros vídeos ou vídeo exemplo -->
                        <video id="mainVideo" class="w-100 rounded" controls poster="{{ $course->image_url ?? '' }}">
                            <source id="mainVideoSource" src="{{ $videoUrl ?: 'https://www.w3schools.com/html/mov_bbb.mp4' }}" type="video/mp4">
                            Seu navegador não suporta o elemento de vídeo.
                        </video>
                    @endif
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-{{ $course->difficulty_level === 'iniciante' ? 'info' : ($course->difficulty_level === 'intermediario' ? 'warning' : 'danger') }} me-2">
                        {{ $course->difficulty_level_label ?? ucfirst($course->difficulty_level) }}
                    </span>
                    <span class="text-muted me-3"><i class="bi bi-clock me-1"></i>{{ $course->duration ?? '---' }}</span>
                    <span class="text-muted"><i class="bi bi-person me-1"></i>{{ $course->instructor->name ?? 'Instrutor(a) não informado(a)' }}</span>
                </div>
                <div class="mb-2">
                    @if($course->tags)
                        @foreach(is_array($course->tags) ? $course->tags : json_decode($course->tags, true) as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Sobre o curso:</strong>
                    <div>{{ $course->curriculum ?? 'Currículo não informado.' }}</div>
                </div>
                @if(!$isEnrolled)
                    <button class="btn btn-primary" onclick="enrollCourse({{ $course->id }})">
                        <i class="bi bi-plus-circle me-2"></i>Matricular-se neste curso
                    </button>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>Você já está matriculado neste curso!
                    </div>
                @endif
            </div>
        </div>
        <!-- Aqui pode ir conteúdo adicional, como avaliações, comentários, etc. -->
    </div>
    <div class="col-lg-4">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Conteúdo do Curso</h5>
                <div class="accordion" id="modulesAccordion">
                    @foreach($modules as $mIndex => $module)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $mIndex }}">
                                <button class="accordion-button {{ $mIndex > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $mIndex }}" aria-expanded="{{ $mIndex === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $mIndex }}">
                                    {{ $module->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $mIndex }}" class="accordion-collapse collapse {{ $mIndex === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $mIndex }}" data-bs-parent="#modulesAccordion">
                                <div class="accordion-body p-0">
                                    <ul class="list-group list-group-flush">
                                        @foreach($module->lessons as $lesson)
                                            <li class="list-group-item lesson-item border-0 mb-2">
                                                <div class="d-flex align-items-center justify-content-between p-3 rounded lesson-card">
                                                    <div class="d-flex align-items-center flex-grow-1">
                                                        <div class="lesson-icon me-3">
                                                            <i class="bi bi-play-circle-fill"></i>
                                                        </div>
                                                        <div class="lesson-content flex-grow-1">
                                                            <button type="button" class="btn btn-link p-0 text-start lesson-link fw-medium" data-video-url="{{ $lesson->video_url }}">
                                                                {{ $lesson->title }}
                                                            </button>
                                                            @if($lesson->description)
                                                                <div class="lesson-description text-muted small mt-1">
                                                                    {{ Str::limit($lesson->description, 80) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="lesson-meta d-flex align-items-center">
                                                        @if($lesson->duration)
                                                            <span class="badge bg-light text-dark me-2">
                                                                <i class="bi bi-clock me-1"></i>{{ $lesson->duration }}
                                                            </span>
                                                        @endif
                                                        <div class="lesson-status">
                                                            <i class="bi bi-check-circle-fill text-success" style="display: none;"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function enrollCourse(courseId) {
    if (confirm('Deseja realmente se matricular neste curso?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = `/student/courses/${courseId}/enroll`;
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
                    alert(data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Erro ao realizar matrícula.');
            });
    }
}

function changeVideo(videoUrl) {
    if (!videoUrl) return;
    
    const playerContainer = document.querySelector('.ratio.ratio-16x9');
    const isYouTube = videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be');
    
    if (isYouTube) {
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)?\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const matches = videoUrl.match(regex);
        const youtubeId = matches ? matches[1] : '';
        
        if (youtubeId) {
            const embedUrl = `https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1&showinfo=0`;
            
            playerContainer.innerHTML = `
                <iframe 
                    id="mainVideo"
                    class="w-100 rounded" 
                    src="${embedUrl}" 
                    title="Vídeo da Lição"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            `;
        }
    } else {
        playerContainer.innerHTML = `
            <video id="mainVideo" class="w-100 rounded" controls>
                <source id="mainVideoSource" src="${videoUrl}" type="video/mp4">
                Seu navegador não suporta o elemento de vídeo.
            </video>
        `;
        
        const video = document.getElementById('mainVideo');
        video.load();
        video.play().catch(e => console.log('Auto-play bloqueado pelo navegador'));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const lessonCards = document.querySelectorAll('.lesson-card');
    const lessonLinks = document.querySelectorAll('.lesson-link');
    
    lessonCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            const link = this.querySelector('.lesson-link');
            const videoUrl = link.getAttribute('data-video-url');
            
            if (videoUrl && videoUrl.trim() !== '') {
                changeVideo(videoUrl);
                
                // Remover classe active de todos os cards
                lessonCards.forEach(c => c.classList.remove('active'));
                // Adicionar classe active no card clicado
                this.classList.add('active');
                
                // Mostrar ícone de check
                const checkIcon = this.querySelector('.bi-check-circle-fill');
                if (checkIcon) {
                    checkIcon.style.display = 'inline-block';
                }
            }
        });
    });
});
</script>
@endsection

<style>
.lesson-item {
    background: transparent;
    padding: 0;
}

.lesson-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.lesson-card:hover {
    background: #e3f2fd;
    border-color: #2196f3;
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(33, 150, 243, 0.15);
}

.lesson-card.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

.lesson-card.active .lesson-link {
    color: white !important;
}

.lesson-card.active .lesson-description {
    color: rgba(255, 255, 255, 0.8) !important;
}

.lesson-card.active .badge {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.lesson-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.lesson-card.active .lesson-icon {
    background: rgba(255, 255, 255, 0.2);
}

.lesson-link {
    color: #2c3e50 !important;
    text-decoration: none !important;
    font-size: 1rem;
    line-height: 1.4;
}

.lesson-link:hover {
    color: #667eea !important;
}

.lesson-description {
    font-size: 0.85rem;
    line-height: 1.3;
}

.lesson-meta .badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.6rem;
}

.accordion-item {
    border: none;
    margin-bottom: 1rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.accordion-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    border: none;
    font-weight: 600;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    color: white !important;
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border: none;
}

.accordion-body {
    padding: 0;
    background: white;
}
</style>


