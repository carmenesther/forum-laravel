@forelse($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h5><a href="{{$thread->path()}}">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{$thread->title}}
                                </strong>
                            @else
                                {{$thread->title}}
                            @endif
                        </a>
                    </h5>

                    <h6>Posted By: <a href="{{route('profile', $thread->creator)}}">{{$thread->creator->name}}</a></h6>
                </div>
                <a href="{{$thread->path()}}">
                    {{$thread->replies_count}} {{ Str::plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="body">{{$thread->body}}</div>
        </div>
        <div class="card-footer">
            {{ $thread->visits() }} Visits
        </div>
    </div>
@empty
    <p>There are not relevant results at this time</p>
@endforelse
