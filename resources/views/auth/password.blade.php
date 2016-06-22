@extends('site.layout')


@section('content')
<div class="category-content">
  <div class="clear"></div>
  <div class="category-title">
  Востановление пароля
</div>
<div class="category-title-line">
</div>

<div class="search-mail fl">
    <div class="search-header">
      Новый пользователь?
  </div>
  <div class="register-left-content">
      <a href="/auth/register" >Зарегистрироваться</a>

  </div>
</div>
<form method="POST" action="/password/email">
    {!! csrf_field() !!}
    <div class="register-content fl">

      <div class="register-title">
        Данные аккаунта
    </div>

    @if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <div class="register-input">
        <p>Email</p>
        <input type="text" name="email" placeholder="Email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif>
    </div>


    <input type="submit" value="Востановить пароль" value="{{ old('email') }}" class="register-button">
</div>
</div>
</div>
<div class="clear"></div>

@stop