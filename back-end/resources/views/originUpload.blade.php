<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{asset('api/video/originalUpload')}}" method="POST" enctype="multipart/form-data">>
		<input type="hidden" value='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZW1iZXJfcGsiOjIsImVtYWlsIjoiMUBnbWFpbC5jb20iLCJuaWNrbmFtZSI6IjExIiwicHJvZmlsZSI6bnVsbCwiYXR0ZW5kYW5jZV9zdCI6IlQiLCJwcmVtaWVyX3N0IjoiRiIsInByZW1pZXJfZHQiOm51bGwsInBvaW50IjowfQ.BAzNwkeeuQh0K-x6C9KqHUaj_CTkXjd_RTJoHhQBIiY' name='token'>

		<input type="file" name='video'>
		<input type="submit">
	</form>
</body>
</html>