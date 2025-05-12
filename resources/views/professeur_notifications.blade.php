@extends('layouts.professeur')

@section('content')
<div class="container">
    <h2>Mes Notifications</h2>

    @if($notifications->isEmpty())
        <p>Aucune notification.</p>
    @else
        <div class="list-group">
          @foreach($notifications as $notification)
    <form action="{{ route('notifications.markAsRead', $notification->id_notification) }}" method="POST" 
          class="list-group-item list-group-item-action d-flex justify-content-between" 
          style="background-color: transparent; border: 1px solid #dee2e6; border-radius: 6px; margin-bottom: 12px; padding: 12px 16px;">
        @csrf
        <button type="submit" 
                class="btn btn-link p-0 text-start w-100 text-decoration-none" 
                style="color: #6c757d; text-align: left;">
            <div>
                <strong style="display: block; margin-bottom: 5px;">{{ $notification->contenu }}</strong>
                <small class="text-muted">{{ \Carbon\Carbon::parse($notification->date_notification)->diffForHumans() }}</small>
            </div>
        </button>
    </form>
@endforeach

        </div>
    @endif
</div>
@endsection


