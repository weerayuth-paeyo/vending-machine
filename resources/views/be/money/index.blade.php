<html>
<head>
    <meta charset=" ">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>
<body class="container">
    <h2>รายการประเภทเงิน</h2>
    <br>
    <a href="{{route('Admin::money.get.edit')}}" class="btn btn-primary">บรรจุเงิน</a>
    <a href="{{route('Admin::dashboard')}}" class="btn btn-primary">หน้าหลัก</a>
    <br>
    <br>

    <table id="tableMoney" class="display" style="width:100%">
        <thead>
        <tr>
            <th>ลำกับ</th>
            <th>ประเภท</th>
            <th>จำนวน</th>
            <th>รวมทัเงหมด</th>
            <th>จัดการ</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>ลำกับ</th>
            <th>ประเภท</th>
            <th>จำนวน</th>
            <th>รวมทัเงหมด</th>
            <th>จัดการ</th>
        </tr>
        </tfoot>
    </table>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableMoney').DataTable( {
            "ajax": "{{route('Admin::money.get.dataTable')}}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "name" },
                { "data": "amount" },
                {
                    render:function (data, type, row, meta) {
                        var sum;
                        if(row.totalMoney == null){
                            sum = 0;
                        }else{
                            sum = row.totalMoney
                        }
                        return sum+' บาท';
                    }
                },
                {
                    render:function (data, type, row, meta) {
                        var html = '<a href="edit/'+row.id+'" class="bi bi-pencil-square"></a> &nbsp; <a onclick="del('+row.id+')" class="bi bi-trash " style="color: orangered"></a>'
                        return html;
                    }
                },
            ]
        } );
    } );

    function del(id) {
        $.ajax({
            url:"{{route('Admin::money.post.delete')}}",
            type:"post",
            data:{
                id:id,
                _token: "{{@csrf_token()}}",
            },
            success: function(response){
                console.log(response.data.id)
                var obj = response.data;
                alert('Delete '+obj.name+' '+response.message);
                $('#tableMoney').DataTable().ajax.reload();
            },
            error: function(){
                alert('error!');
                $('#tableMoney').DataTable().ajax.reload();
            }
        })
    }
</script>
