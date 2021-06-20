<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display product</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <body style="display: flex; justify-content:space-evenly; flex-flow: row wrap">
        @foreach($xuat as $x)
        <div class="card" style="width: 18rem; margin: 10px">
            <img src="/images/{{$x->profile}}" class="card-img-top" style="height: 180px;">
            <div class="card-body">
                <h5 class="card-title">{{$x->name}}</h5>
                <p class="card-text">{{$x->describe}}</p>
                <p class="card-text">{{$x->price }}</p>
                <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
        </div>
        @endforeach
    </body>
</body>

</html>