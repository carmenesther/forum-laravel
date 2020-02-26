<div id="reply-{{$reply->id}}" class="card">
    <div class="card-header">
        <div class="form-inline">
            <h5 class="flex ">
                <a href="{{route('profile', $reply->owner)}}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}...
            </h5>
            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count}} {{ Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>

    @can('update', $reply)
        <div class="card-footer">
            <form action="/replies/{{$reply->id}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    @endcan

</div>
