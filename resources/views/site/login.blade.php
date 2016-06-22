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
	11
         @if(Session::get('error'))
         1
<!--            <div class="errors">
            <strong>Упс!</strong> Есть проблемы с вашими полями.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> -->
        @endif

			<div class="register-title">
				Данные аккаунта
			</div>
			<div class="register-input">
				<p>Email</p>
				<input type="text" name="email" placeholder="Email">
			</div>
			<div class="register-input">
				<p>Пароль</p>
				<input type="password" name="password" placeholder="Пароль">
			</div>

			<a href="#">Забыли пароль?</a>

			<input type="submit" value="Авторизироваться" class="register-button">
		</div>
	</div>
</div>
<div class="clear"></div>




@stop