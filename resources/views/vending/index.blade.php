<html>
<head>
    <meta charset=" ">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <style>
        .circle {
            width: 90px;
            height: 90px;
            border-radius: 50px;
            background: grey;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 25%;
            padding: 10px; margin: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .container {
            padding: 2px 16px;
        }

    </style>
</head>
<body class="container">
    <h2>ตู้ขายสินค้า</h2>

    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    <br>
    @if(!$user)
    <a class="btn btn-primary" href="{{route('Admin::dashboard')}}">เข้าสู่ระบบ</a>
    @else
    <a class="btn btn-primary" href="{{route('get.logout')}}">ออกจากระบบ</a>
    <a class="btn btn-primary" href="{{route('Admin::dashboard')}}">ไปยังหน้าหลัก</a>
    @endif
    <br>
    <br>
    <div class="row">
        <h5>หยอดเหรียญ</h5>
        <button class="circle" onclick="Vending(1)">1 บาท</button>
        <button class="circle" onclick="Vending(2)">2 บาท</button>
        <button class="circle" onclick="Vending(5)">5 บาท</button>
        <button class="circle" onclick="Vending(10)">10 บาท</button>
        <button class="circle" onclick="Vending(20)">20 บาท</button>
        <button class="circle" onclick="Vending(50)">50 บาท</button>
        <button class="circle" onclick="Vending(100)">100 บาท</button>
        <button class="circle" onclick="Vending(500)">500 บาท</button>
        <button class="circle" onclick="Vending(1000)">1000 บาท</button>
    </div>
    <br>
    <hr>
    <br>
    <div class="row">
        <div class="col-3">
            <h5>ยอดเงิน:</h5>
            <input type="text" name="balance" id="balance" value="0" readonly>
        </div>
        <div class="col-3">
            <h5>เงินทอน/คืน:</h5>
            <input type="text" name="change" id="change" value="0" readonly>
        </div>
        <div class="col-3">
            <button class="btn btn-danger" onclick="cancel()">ยกเลิกการซื้อ</button>
            {{--            <button class="btn btn-primary">ล้างข้อมูล</button>--}}
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div id="descriptionsExchange">
        <div class="row">
            <h4>รายละเอียดการทอนเงิน :</h4>
            <div class="col-4">
                <p id="1b">ประเภท 1 บาท : </p>
                <p id="2b">ประเภท 2 บาท : </p>
                <p id="5b">ประเภท 5 บาท : </p>
            </div>
            <div class="col-4">
                <p id="10b">ประเภท 10 บาท : </p>
                <p id="20b">ประเภท 20 บาท : </p>
                <p id="50b">ประเภท 50 บาท : </p>
            </div>
            <div class="col-4">
                <p id="100b">ประเภท 100 บาท : </p>
                <p id="500b">ประเภท 500 บาท : </p>
                <p id="1000b">ประเภท 1000 บาท : </p>
            </div>
        </div>
        <br>
        <hr>
    </div>
    <br>
    <div class="row">
        <?php
        $products = \App\Models\Product::get();
        foreach ($products as $index => $product){
        ?>
        <div class="card">
            <img src="https://f.ptcdn.info/249/034/000/1439044192-o.jpg" alt="Avatar" style="width:100%">
            <div class="container">
                <h4><b><?=$product->name?></b></h4>
                <p>ราคา : <?=$product->price?></p>
            </div>
            <button class="btn btn-primary data-check-price" data-id="{{$product->id}}" onclick="buy({{$product->id}},{{$product->price}},'{{$product->name}}')" disabled>ซื้อ</button>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
{{--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    checkStock();
    function checkStock() {
        $.ajax({
            url : "{{route('product.post.postProduct')}}",
            type: "post",
            data: {
                _token: "{{@csrf_token()}}",
            },
            success:function (response) {
                console.log(response);
                var datas = response.data;
                for (var i in datas){
                    if (datas[i].amount != 0 ){
                        $('.data-check-price[data-id='+datas[i].id+']').attr('disabled','disabled');
                    }else {
                        $('.data-check-price[data-id='+datas[i].id+']').attr('disabled','disabled');
                        $('.data-check-price[data-id='+datas[i].id+']').text('สินค้าหมด');
                        $('.data-check-price[data-id='+datas[i].id+']').removeClass('btn btn-primary');
                        $('.data-check-price[data-id='+datas[i].id+']').addClass('btn btn-danger');
                    }
                }
            },
            error:function () {
                alert("Error!")
            }
        });
    }

    async function Vending(value) {
        var vending = $('#balance').val();
        vending = parseInt(vending)+parseInt(value);
        $('#balance').val(vending);
        await checkBalance(vending);
    }

    function checkBalance(value) {
        $.ajax({
           url : "{{route('product.post.postProduct')}}",
           type: "post",
           data: {
               _token: "{{@csrf_token()}}",
           },
           success:function (response) {
               console.log(response);
               var datas = response.data;
               for (var i in datas){
                    if (value >= datas[i].price && datas[i].amount != 0){
                        console.log('สามารถซื้อสินค้า ID: '+datas[i].id+' ชื่อสินค้า: '+datas[i].name)
                        $('.data-check-price[data-id='+datas[i].id+']').removeAttr('disabled');
                    }
               }
           },
           error:function () {
                alert("Error!")
            }
        });
    }

    function cancel() {
        var vending = $('#balance').val();
        $('#balance').val(0);
        $('#change').val(vending);
        checkStock();
    }

    function buy(id, price, name) {
        var vending = $('#balance').val();
        var change = vending-price;
        console.log('ราคาสินค้า: ',price);
        console.log('เงินทอน: ',change);
        if (change > 0){
            checkMoney(id, change, name, price);
        }else {
            $('#change').val(change);
            $('#balance').val(change);
            $.ajax({
                url : "{{route('product.post.postBuyProduct')}}",
                type: "post",
                data: {
                    _token: "{{@csrf_token()}}",
                    id: id,
                },
                success:function (response) {
                    console.log(response);
                    if (response.status === 'failed'){
                        $('#balance').val(0);
                        checkStock();
                    }else if (response.status === 'success'){
                        $('#1b').text('ประเภท 1 บาท : ');
                        $('#2b').text('ประเภท 2 บาท : ');
                        $('#5b').text('ประเภท 5 บาท : ');
                        $('#10b').text('ประเภท 10 บาท : ');
                        $('#20b').text('ประเภท 20 บาท : ');
                        $('#50b').text('ประเภท 50 บาท : ');
                        $('#100b').text('ประเภท 100 บาท : ');
                        $('#500b').text('ประเภท 500 บาท : ');
                        $('#1000b').text('ประเภท 1000 บาท : ');
                        for(var i in response.data){
                            $('#'+response.data[i].value+'b').text('ประเภท '+response.data[i].value+' บาท : '+response.data[i].useAmount);
                        }
                        $('#change').val(change);
                        $('#balance').val(0);
                        checkStock();
                        alert('กรุณารับสินค้า : '+name+' ราคา : '+price+ ' บาท')
                    }
                },
                error:function () {
                    alert("Error!")
                }
            });
        }
    }

    function checkMoney(id, checkMoney, name, price) {
        let status;
        $.ajax({
            url : "{{route('product.post.checkMoney')}}",
            type: "post",
            data: {
                _token: "{{@csrf_token()}}",
                id: id,
                checkMoney: checkMoney,
            },
            success:function (response) {
                console.log(response);
                if (response.status === 'failed'){
                    alert(response.message);
                    $('#change').val($('#balance').val());
                    $('#balance').val(0);
                    checkStock();
                }else if (response.status === 'success'){
                    $('#1b').text('ประเภท 1 บาท : ');
                    $('#2b').text('ประเภท 2 บาท : ');
                    $('#5b').text('ประเภท 5 บาท : ');
                    $('#10b').text('ประเภท 10 บาท : ');
                    $('#20b').text('ประเภท 20 บาท : ');
                    $('#50b').text('ประเภท 50 บาท : ');
                    $('#100b').text('ประเภท 100 บาท : ');
                    $('#500b').text('ประเภท 500 บาท : ');
                    $('#1000b').text('ประเภท 1000 บาท : ');
                    for(var i in response.data){
                        $('#'+response.data[i].value+'b').text('ประเภท '+response.data[i].value+' บาท : '+response.data[i].useAmount);
                    }
                    $('#change').val(checkMoney);
                    $('#balance').val(0);
                    checkStock();
                    alert('กรุณารับสินค้า : '+name+' ราคา : '+price+ ' บาท')
                }
            },
            error:function () {
                alert("Error!")
            }
        });
    }

</script>
