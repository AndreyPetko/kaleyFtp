@extends('site.layout')


@section('content')



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

			<div class="register-title">
				Личные данные
			</div>
			<div class="register-input">
				<p>ФИО</p>
				<input type="text" name="name" placeholder="ФИО">
			</div>
			<div class="register-input">
				<p>Телефон</p>
				<input type="text" name="phone" placeholder="Телефон">
			</div>
			<div class="register-input">
				<p>Адресс</p>
				<input type="text" name="address" placeholder="Адресс">
			</div>
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