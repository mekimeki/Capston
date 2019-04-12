<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="UTF-8">
	<title>Document</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

	<form action="/register-test" method='post'>
		email<input type="text" name='email' required><br>
		nickname<input type="text" name='nickname' required><br>
		pw<input type="password" name='password' required><br>
		pw_conirmation<input id="password-confirm" type="password" name="password_confirmation" required>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<form action="/login-test" method='post'>
		email<input type="text" name='email' required><br>
		pw<input type="password" name='password' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
</body>
</html>