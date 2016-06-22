@if(isset($breadcrumbs))
<div class="breadcrumbs">
    <a href="/">
        <div class="home-image fl">
            <img src="{{ url('site/images/imagesGG60IGZZ.png') }}" alt="">
        </div>
    </a>
    @foreach($breadcrumbs as $url => $breadcrumb)
    <div class="breadcrumbs-next fl">
        <img src="{{ url('site/images/bread-strelochka.png') }}" alt="">
    </div>
    <div class="breadcrumbs-text fl">
        @if($breadcrumb != end($breadcrumbs))
        <a href="{{$url}}">{{$breadcrumb}}</a>
        @else
            {{$breadcrumb}}
        @endif
    </div>
    @endforeach
</div>
@endif