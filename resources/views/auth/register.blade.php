@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')



<div class="category-content">
    <div class="clear"></div>
    <div class="category-title">
        Регистрация
    </div>
    <div class="category-title-line">
    </div>

    <div class="search-mail fl">
        <div class="search-header">
            Уже есть аккаунт?
        </div>
        <div class="register-left-content">
            <a href="/login" >Войти</a>

        </div>
    </div>
    <form action="/auth/register" method="POST">
        {!! csrf_field() !!}
        <div class="register-content fl">
           @if (count($errors) > 0)
           <div class="errors">
            <strong>Упс!</strong> Есть проблемы с вашими полями.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="register-title">
            Личные данные
        </div>
        <div class="register-input">
            <p>ФИО</p>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="ФИО">
        </div>
        <div class="register-input">
            <p>Телефон</p>
            <input type="text" name="phone" class="phone" value="{{ old('phone') }}" placeholder="Телефон">
        </div>
        <div class="register-input">
            <p>Адресс</p>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Адресс">
        </div>
        <div class="register-title">
            Данные аккаунта
        </div>
        <div class="register-input">
            <p>Email</p>
            <input type="text" name="email" value="{{ old('email') }}" placeholder="Email">
        </div>
        <div class="register-input">
            <p>Пароль</p>
            <input type="password" name="password" value="{{ old('password') }}" placeholder="Пароль">
        </div>
        <div class="register-input">
            <p>Подтвердить пароль</p>
            <input type="password" name="password_confirmation" placeholder="Подтвердить пароль">
        </div>
        <div class="register-mail fl">
            <!-- <p>Подписаться на рассылку <input type="checkbox" class="fl"></p> -->

        </div>

        <input type="submit" value="Зарегистрироваться" class="register-button">

    </div>
</form>
</div>
<div class="clear"></div>

@stop


@section('mobile')
@include('elements.breadcrumbs')
<div class="category-title">
        Регистрация
    </div>
    <div class="category-title-line">
    </div>

    <div class="search-header">
            Уже есть аккаунт?
        </div>
        <div class="register-left-content">
            <a href="/login" >Войти</a>

        </div>
 <form action="/auth/register" method="POST">
        {!! csrf_field() !!}
        <div class="register-content-mobile fl">
           @if (count($errors) > 0)
           <div class="errors">
            <strong>Упс!</strong> Есть проблемы с вашими полями.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="register-title">
            Личные данные
        </div>
        <div class="register-input">
            <p>ФИО</p>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="ФИО">
        </div>
        <div class="register-input">
            <p>Телефон</p>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Телефон">
        </div>
        <div class="register-input">
            <p>Адресс</p>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Адресс">
        </div>
        <div class="register-title">
            Данные аккаунта
        </div>
        <div class="register-input">
            <p>Email</p>
            <input type="text" name="email" value="{{ old('email') }}" placeholder="Email">
        </div>
        <div class="register-input">
            <p>Пароль</p>
            <input type="password" name="password" value="{{ old('password') }}" placeholder="Пароль">
        </div>
        <div class="register-input">
            <p>Подтвердить пароль</p>
            <input type="password" name="password_confirmation" placeholder="Подтвердить пароль">
        </div>
        <div class="register-mail fl">
            <!-- <p>Подписаться на рассылку <input type="checkbox" class="fl"></p> -->

        </div>

        <input type="submit" value="Зарегистрироваться" class="register-button">

    </div>
</form>

<div class="clear"></div>
@stop