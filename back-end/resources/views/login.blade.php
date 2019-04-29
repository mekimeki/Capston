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
	<br>
	<form action="/login-test" method='post'>
		email<input type="text" name='email' required><br>
		pw<input type="password" name='password' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<br>
	<form action="/jwtLogin" method='post'>
		email<input type="text" name='email' required><br>
		pw<input type="password" name='password' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
<br>
	<form action="/upload-test" method='post'>
		submit<input type="text" name='submit' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<br>
	<form action="api/video/originalUpload" method='post' enctype="multipart/form-data">
		file<input type="file" name='video' required><br>
		<input type="hidden" name='token' value='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZW1iZXJfcGsiOjIsImVtYWlsIjoiMUBnbWFpbC5jb20iLCJuaWNrbmFtZSI6IjExIiwicHJvZmlsZSI6bnVsbCwiYXR0YW5kYW5jZV9zdCI6IkYiLCJwcmVtaWVyX3N0IjoiRiIsInByZW1pZXJfZHQiOm51bGwsInBvaW50IjowfQ.nGpiFo7Ia2A9_IUfMYYUXZ84DPZ2nkcjNFoOA8-OFzw'><br>
		{{csrf_field()}}
		<input type="submit">
	</form>

	<br>
	<form action="api/subtitle/originalUpload" method='post' enctype="multipart/form-data">
		subtitle<input type="file" name='subtitle' required><br>
		<input type="hidden" name='video_pk' value='45'><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<br>

	<br>
	<form action="/SResult" method='post' >
		<input type="hidden" name='token' value='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZW1iZXJfcGsiOjIsImVtYWlsIjoiMUBnbWFpbC5jb20iLCJuaWNrbmFtZSI6IjExIiwicHJvZmlsZSI6bnVsbCwiYXR0YW5kYW5jZV9zdCI6IkYiLCJwcmVtaWVyX3N0IjoiRiIsInByZW1pZXJfZHQiOm51bGwsInBvaW50IjowfQ.nGpiFo7Ia2A9_IUfMYYUXZ84DPZ2nkcjNFoOA8-OFzw'><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<br>
</body>
</html>