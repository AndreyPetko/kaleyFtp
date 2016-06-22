@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="category-content">
    <div class="category-filter fl">
        <div class="filter-header">
            ДРУГИЕ СТАТЬИ
        </div>
        <div class="filter-content">
            @foreach($otherArticles as $otherArticle)
            <a href="/article/{{$otherArticle->url}}">
                <div @if($article->id == $otherArticle->id)  class="article-filter-title-act" @else class="article-filter-title" @endif>
                    {{$otherArticle->name}}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="category-single-art-content fl">
        <div class="category-title">
            {{$article->name}}
        </div>
        <div class="category-title-line">
        </div>
        <div class="article-img"><img src="{{ url('articles_images/' . $article->image) }}" alt=""></div>
        <div class="article-preview">
            {{$article->previewText}}
        </div>
        <div class="article-content">
           {!! $article->text !!}
       </div>

   </div>

   <div class="clear"></div>


</div>

@stop

@section('mobile')
@include('elements.breadcrumbs')
<div class="category-title">
            {{$article->name}}
        </div>
        <div class="category-title-line">
        </div>
 <div class="article-img-mobile"><img src="{{ url('articles_images/' . $article->image) }}" alt=""></div>
        <div class="article-preview-mobile">
            {{$article->previewText}}
        </div>
        <div class="article-content">
           {!! $article->text !!}
       </div>
@stop