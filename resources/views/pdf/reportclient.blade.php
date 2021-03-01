
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div>Reporte cliente</div>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">N°</th>
                <th scope="col">NOMBRE</th>
                <th scope="col">EMPRESA</th>
                <th scope="col">DIRECCIÓN</th>
                <th scope="col">CIUDAD</th>
                <th scope="col">CORREO</th>
                </tr>
            </thead>
            <tbody>
            @foreach($clients as $c)
                <tr>
                <th>{{$c->id}}</th>
                <th>{{$c->name}}</th>
                <th>{{$c->name_company}}</th>
                <th>{{$c->street_address}}</th>
                <th>{{$c->city}}</th>
                <th>{{$c->email}}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</html>