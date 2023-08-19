<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <title>Document</title>
    @vite('resources/css/app.css')
    <style>
        body{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">    
        @foreach ($products as $product)
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>   
        @endforeach
        <div class="mt-3">{{ $products->links() }}</div>
    </div>
    
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>