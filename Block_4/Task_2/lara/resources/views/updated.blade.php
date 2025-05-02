    @foreach($posts as $post)
        <div class="post">
            <strong>{{ $post->author }}</strong>:
            <p>{{ $post->message }}</p>
            <small>{{ $post->created_at->format('d.m.Y H:i') }}</small>
            <small class="pid">{{ $post->id }} </small>
            <button class="delete-post" style="color:red; cursor:pointer;">Удалить</button>
        </div>
    @endforeach
