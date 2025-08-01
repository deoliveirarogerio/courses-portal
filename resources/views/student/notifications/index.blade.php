@extends('student.layouts.dashboard')

@section('content')
    <h2>Minhas Notificações</h2>

    <ul class="list-group">
        @forelse ($notifications as $notification)
            <li class="list-group-item {{ $notification->read_at ? '' : 'fw-bold' }}">
                <a href="{{ $notification->data['url'] ?? '#' }}">
                    {{ $notification->data['message'] }}
                </a>
                <span class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
        @empty
            <li class="list-group-item">Nenhuma notificação encontrada.</li>
        @endforelse
    </ul>

    <div class="mt-3">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
@endsection
