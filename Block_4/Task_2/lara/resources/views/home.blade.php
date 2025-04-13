@extends('layouts.app')

@section('title-block')
    Главная страница
@endsection

@section('content')
    <div class="img_block">
        <div class="img_item">
            <img src="{{ asset('images/img1.png') }}" alt="Портрет Пушкина">
            <p class="image-caption">Пушкин А.С.</p>
        </div>
        <div class="img_item">
            <img src="{{ asset('images/img2.png') }}" alt="Портрет Лермонтова">
            <p class="image-caption">Лермонтов М.Ю.</p>
        </div>
        <div class="img_item">
            <img src="{{ asset('images/img3.png') }}" alt="Портрет Ахматовой">
            <p class="image-caption">Ахматова А.А.</p>
        </div>
        <div class="img_item">
            <img src="{{ asset('images/img4.png') }}" alt="Портрет Достоевского">
            <p class="image-caption">Достоевский Ф.М.</p>
        </div>
        <div class="img_item">
            <img src="{{ asset('images/img5.png') }}" alt="Портрет Гоголя">
            <p class="image-caption">Гоголь Н.В.</p>
        </div>
    </div>

@endsection
