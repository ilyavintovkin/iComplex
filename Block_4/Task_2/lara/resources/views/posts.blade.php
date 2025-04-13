<!-- resources/views/posts.blade.php -->
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

<hr>

@foreach($posts as $post)
    <div class="post">
        <strong>{{ $post->author }}</strong>:
        <p>{{ $post->message }}</p>
        <small>{{ $post->created_at->format('d.m.Y H:i') }}</small>
    </div>
@endforeach
@endsection

