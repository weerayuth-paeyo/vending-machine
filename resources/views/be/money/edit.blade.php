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
    <h2>บรรจุเงินเพิ่ม</h2>
    <br>
    <br>
    <form action="{{route('Admin::money.post.edit',$id)}}" method="post">
        @csrf
        มูลค่า(ประเภทเงิน) :
        <select name="moneyType" style="width: 8rem" id="moneyType" <?php if($id){echo 'disabled';}?>>
            <?php
            $moneyTypes = \App\Models\MoneyType::get();
            if ($moneyTypes){
                foreach ($moneyTypes as $moneyType){
            ?>
                <option <?php if ($id == $moneyType->id){ echo 'selected';}?> value="<?= $moneyType->id?>"><?= $moneyType->name?></option>
            <?php
                }
            }
            ?>
        </select>
        <br>
        <br>
        Amount :
        <input type="text" name="amount" value="">
        <br>
        <br>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="{{route('Admin::money.get.index')}}" class="btn btn-danger">Cancel</a>
    </form>
</body>
</html>
