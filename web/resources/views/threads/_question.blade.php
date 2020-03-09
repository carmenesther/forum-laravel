{{-- Editing --}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" value="{{$thread->title}}" class="form-control">
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <textarea class="form-control" rows="10">{{$thread->body}}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <div class="level">
            <button class="btn btn-secondary btn-sm level-item" @click="editing = true" v-show="! editing">Edit</button>
            <button class="btn btn-primary btn-sm level-item" @click="">Update</button>
            <button class="btn btn-secondary btn-sm level-item" @click="editing = false">Cancel</button>
            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{-- Viewing --}}
<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <img src="{{ asset($thread->creator->avatar_path)}}" width="25" height="25" class="mr-2">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">
                {{$thread->creator->name}} </a> posted:
                 {{$thread->title}}
            </span>
        </div>
    </div>

    <div class="card-body">
        {{$thread->body}}
    </div>

    <div class="card-footer">
        <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
    </div>
</div>
