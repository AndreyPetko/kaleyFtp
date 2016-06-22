@extends('dashboard.dashboardLayout')


@section('dashboardContent')
<form method="POST" >
	<input type="hidden" value="{{csrf_token()}}" name="_token">
	<div class="register-content fl">
		<div class="register-title">
			Личные данные
		</div>
		<div class="register-input">
			<p>ФИО</p>
			<input type="text" name="name" value="{{Auth::user()->name}}" placeholder="ФИО">
		</div>
		<div class="register-input">
			<p>Телефон</p>
			<input type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="Телефон">
		</div>
		<div class="register-input">
			<p>Адресс</p>
			<input type="text" name="address" value="{{ Auth::user()->address }}" placeholder="Адресс">
		</div>
		<div class="register-title">
			Данные аккаунта
		</div>
		<div class="register-input">
			<p>Email</p>
			<input type="text" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
		</div>

		<div class="register-mail fl">
			<!-- <p>Подписаться на рассылку <input type="checkbox" class="fl"></p> -->

		</div>

		<div class="edit-password">
			<a href="/reset-password">Изменить пароль</a>
		</div>

		<input type="submit" value="Обновить" class="register-button">
	</div>
</form>
@stop

@section('dashboardMobile')
1

@stop