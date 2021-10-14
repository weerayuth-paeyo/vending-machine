<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body >
<form action="{{route('post.login')}}" method="post">
    @csrf
    UserName:
    <input type="text" name="userName">
    <br>
    <br>
    Password:
    <input type="password" name="password">
    <br>
    <br>
    <input type="submit" value="เข้าสู่ระบบ">
</form>
</body>
</html>
