<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>

  <ul>
    @foreach($datas as $data)
    <li>
      {{ $data }}
    </li>
    @endforeach
  </ul>
  <ul>
    @foreach($analy as $data)
    <li>{{$data}}</li>
    @endforeach
    </ul>
    
</body>

</html>