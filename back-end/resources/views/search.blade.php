<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="UTF-8">
	<title>Document</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

	<form action="/searchJp" method='post'>
		<h2>일본어</h2>
		단어입력<input type="text" name='word' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	<form action="/searchEn" method='post'>
		<h2>영어</h2>
		단어입력<input type="text" name='word' required><br>
		{{csrf_field()}}
		<input type="submit">
	</form>
	
	<form action="api/pictest" method="POST">
		<label for="pic">
			체크
		</label>
		<input type="file" name="picture" id="pic">
		<input type="submit" value="submit" name="submit">
	</form>
</body>
</html>