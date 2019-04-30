    <h3> Order Details for Order {{$order['order_id']}}</h3>
    <h4>
    Ordered by: {!! img('character', $order->user_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
    <a href="{{ route('character.view.sheet', ['character_id' => $order->user_id]) }}">
        <span class="id-to-name" data-id="{{ $order->user_id }}">{{ trans('web::seat.unknown') }}</span>
    </a>
    </h4>
<table id="ordertable" class="table table-hover table-responsive" style="vertical-align: top">
    <thead>
    <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Volume</th>
        <th>Cost</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order['details']['items'] as $detail)
        <tr>
            <td>
               <img src="https://imageserver.eveonline.com/Type/{{ $detail['itemID'] }}_32.png">
                {{$detail['item']}}
            </td>
            <td>
                {{number_format($detail['quantity'])}}
            </td>
            <td>
                {{number_format($detail['volume'])}}m<sup>3</sup>
            </td>
            <td>
                {{number_format( $detail['cost'] )}}
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td>
            Total Volume
        </td>
        <td></td>
        <td>
            {{number_format($order->volume)}}m<sup>3</sup>
        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Subtotal</td>
        <td>{{ number_format($order->sub_total) }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Delivery Fee</td>
        <td>{{ number_format($order->fee + $order->fuel_cost) }}</td>
    </tr>
    <tr>
        <td>
            <button type="button" class="btn btn-xs btn-box-tool" id="multibuyButton" data-toggle="modal" data-target="#multibuyModal">
                Open Multibuy Pastebox.
            </button>

        </td>
        <td></td>
        <td>Total:</td>

        <td>{{number_format($order->total_cost)}}</td>
    </tr>
    </tfoot>
</table>
<div class="modal fade" tabindex="-1" role="dialog" id="multibuyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <h3>Multybuy Pastebox</h3>
            Ctrl+A, Ctrl+C, import into EVE Multibuy.
            <textarea readonly cols="50" rows="25">
            @foreach($order['details']['items'] as $item)
            {{ $item['item']."\t".$item['quantity']}}
            @endforeach
            </textarea>
        </div>
    </div>
</div>

    @push('javascript')
        @include('web::includes.javascript.id-to-name')
    @endpush
