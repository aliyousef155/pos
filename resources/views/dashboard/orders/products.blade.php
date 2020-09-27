<div id="print-area">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{__('site.name')}}</th>
            <th>{{__('site.quantity')}}</th>
            <th>{{__('site.price')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->pivot->quantity}}</td>
                <td>{{$order->total_price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>{{__('site.total')}} <span>{{$order->total_price}}</span></h3>

</div>
<button class="btn btn-primary form-control " id="print-btn">{{__('site.print')}}</button>
