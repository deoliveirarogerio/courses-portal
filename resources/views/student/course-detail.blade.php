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
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="#" class="lesson-link" data-video-url="{{ $lesson->video_url }}">
                                                    {{ $lesson->title }}
                                                </a>
                                                <span class="badge bg-light text-muted">{{ $lesson->duration }}</span>
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

// Troca o vídeo do player ao clicar em uma aula

function changeVideo(videoUrl) {
    if (!videoUrl) return;
    
    const playerContainer = document.querySelector('.ratio.ratio-16x9');
    const isYouTube = videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be');
    
    if (isYouTube) {
        // Extrair ID do vídeo do YouTube
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)?\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const matches = videoUrl.match(regex);
        const youtubeId = matches ? matches[1] : '';
        
        if (youtubeId) {
            const embedUrl = `https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1&showinfo=0`;
            
            // Criar iframe do YouTube
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
        // Criar player HTML5
        playerContainer.innerHTML = `
            <video id="mainVideo" class="w-100 rounded" controls>
                <source id="mainVideoSource" src="${videoUrl}" type="video/mp4">
                Seu navegador não suporta o elemento de vídeo.
            </video>
        `;
        
        // Auto-play para vídeos HTML5
        const video = document.getElementById('mainVideo');
        video.load();
        video.play().catch(e => console.log('Auto-play bloqueado pelo navegador'));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.lesson-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const videoUrl = this.getAttribute('data-video-url');
            changeVideo(videoUrl);
        });
    });
});
</script>
@endsection 