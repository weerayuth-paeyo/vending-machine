<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body class="container">
    <br>
    @if($id)
        <h2>แก้ไขสินค้า</h2>
    @else
        <h2>เพิ่มสินค้า</h2>
    @endif
    <br>
    <br>
    <form action="{{route('Admin::product.post.edit',$id)}}" method="post">
        @csrf
        Product Name :
        <input type="text" name="productName" value="{{$product->name}}">
        <br>
        <br>
        Price :
        <input type="text" name="price" value="{{$product->price}}">
        <br>
        <br>
        Amount :
        <input type="text" name="amount" value="{{$product->amount}}">
        <br>
        <br>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="{{route('Admin::product.get.index')}}" class="btn btn-danger">Cancel</a>
    </form>
</body>
</html>
