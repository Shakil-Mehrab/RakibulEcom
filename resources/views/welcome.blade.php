<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row">
    <div class="col-md-12" style="display: flex;">
    <div style="margin-left:auto;">
    Cart ({{$items->count()}})
    @forelse($items as $item)
        <div>{{$item->name}}*{{$item->quantity}}-Price({{$item->price*$item->quantity}})</div>
    @empty
    @endforelse
    </div>
    </div>
    <div class="com-md-12">
        @forelse($products as $product)
        <div>
        {{$product->name}}-Price({{$product->price}})
        <a href="{{url('product/show/'.$product->id)}}"><button>Product show</button></a>
        </div>
        @empty
        @endforelse
    </div>
    </div>
</body>
</html>