@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="clear"></div>
<div class="category-content">

    <div class="category-katalog-content">
        <div class="category-title">
            Статьи
        </div>
        <div class="category-title-line">
        </div>

        @foreach($articles as $article)
        <a href="/article/{{$article->url}}">
            <div class="category-pre">
                <div class="category-pre-image" style="background: url('{{ url('articles_images/' . $article->image) }}'); background-size: cover; background-repeat: no-repeat;"></div>
                <div class="category-pre-title">{{$article->name}}</div>
            </div>
        </a>
        @endforeach

        <div class="clear"></div>


    </div>
    <?php echo $articles->render(); ?>
</div>

@stop

@section('mobile')
@include('elements.breadcrumbs')
<div class="category-title">
            Статьи
        </div>
        <div class="category-title-line">
        </div>
@foreach($articles as $article)
        <a href="/article/{{$article->url}}">
            <div class="category-pre-mobile">
                <div class="category-pre-image" style="background: url('{{ url('articles_images/' . $article->image) }}'); background-size: cover; background-repeat: no-repeat;"></div>
                <div class="category-pre-title-mobile">{{$article->name}}</div>
            </div>
        </a>
        @endforeach
        <div class="clear"></div>
<?php echo $articles->render(); ?>
@stop
