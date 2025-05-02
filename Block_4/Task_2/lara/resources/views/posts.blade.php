@extends('layouts.app')

@section('title-block')
    Посты
@endsection

@section('content')

@if(session('success'))
    <p class="success-message">{{ session('success') }}</p>
@endif

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <p>
        <input type="text" name="author" placeholder="Автор" required>
    </p>
    <p>
        <textarea name="message" placeholder="Сообщение" required></textarea>
    </p>
    <button type="submit">Добавить пост</button>
</form>
<button class="update-post" style="color:purple; cursor:pointer;">Обновить посты</button>
<hr>

<div id="post-container">
@foreach($posts as $post)
    <div class="post">
        <strong>{{ $post->author }}</strong>:
        <p>{{ $post->message }}</p>
        <small>{{ $post->created_at->format('d.m.Y H:i') }}</small>
        <small class="pid">{{ $post->id }} </small>
        <button class="delete-post" style="color:red; cursor:pointer;">Удалить</button>
    </div>
    @endforeach
</div>
@endsection
@vite(['resources/js/another.js', 'resources/css/app.css'])

