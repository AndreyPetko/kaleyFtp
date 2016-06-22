@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="category-content">
  <div class="clear"></div>
  <div class="category-title">
    Авторизация
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
  <form action="/login" method="POST">
    {!! csrf_field() !!}
    <div class="register-content fl">


      <div class="register-title">
        Данные аккаунта
      </div>
      @if(Session::get('error'))
      <div class="errors">
        <!-- <strong>Упс!</strong> Есть проблемы с вашими полями.<br><br> -->
        <ul>
          <li>Неправильный логин или пароль</li>
        </ul>
      </div>
      @endif
      <div class="register-input">
        <p>Email</p>
        <input type="text" name="email" placeholder="Email">
      </div>
      <div class="register-input">
        <p>Пароль</p>
        <input type="password" name="password" placeholder="Пароль">
      </div>

      <a href="/reset-password">Забыли пароль?</a>

      <input type="submit" value="Авторизироваться" class="register-button">
    </div>
    </form>
  </div>
</div>
<div class="clear"></div>




@stop

@section('mobile')
@include('elements.breadcrumbs')

<div class="category-title">
    Авторизация
  </div>
  <div class="category-title-line">
  </div>

   <form action="/login" method="POST">
    {!! csrf_field() !!}
    <div class="register-content-mobile">


      <div class="register-title">
        Данные аккаунта
      </div>
      @if(Session::get('error'))
      <div class="errors">
        <!-- <strong>Упс!</strong> Есть проблемы с вашими полями.<br><br> -->
        <ul>
          <li>Неправильный логин или пароль</li>
        </ul>
      </div>
      @endif
      <div class="register-input">
        <p>Email</p>
        <input type="text" name="email" placeholder="Email">
      </div>
      <div class="register-input">
        <p>Пароль</p>
        <input type="password" name="password" placeholder="Пароль">
      </div>

      <a class="fr" href="/reset-password">Забыли пароль?</a>
<div class="clear"></div>
    <div class="register-left-content-mobile fl">
      <a href="/auth/register" >Зарегистрироваться</a>

    </div>

      <input type="submit" value="Авторизироваться" class="register-button-mobile">
    </div>
    </form>
<div class="clear"></div>
@stop