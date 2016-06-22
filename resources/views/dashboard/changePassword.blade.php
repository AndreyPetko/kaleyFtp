@extends('dashboard.dashboardLayout')


@section('dashboardContent')
<form method="POST" action="/password/reset" >
<input type="hidden" value="{{csrf_token()}}" name="_token">
<div class="register-content fl">
	<div class="register-title">
		Изменение пароля
	</div>
	<div class="register-input">
	<p>Введите старый пароль</p>
		<input type="text" name="email" placeholder="Старый пароль">
	</div>
	<div class="register-input">
	<p>Введите новый пароль</p>
		<input type="password" name="password"  placeholder="Новый пароль">
	</div>
	<div class="register-input">
	<p>Повторите новый пароль</p>
		<input type="password" name="password_confirmation" placeholder="Повторите новый пароль">
	</div>
	<input type="submit" value="Изменить пароль" class="register-button">

</div>
</form>
@stop