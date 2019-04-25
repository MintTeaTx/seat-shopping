@extends('web::layouts.grids.12')
@section('title', 'Order Confirmation')
@section('page_header', 'Dicks out for Harambe')

@section('full')
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"> Order Confirmation</h3>
    </div>
    <div class="box-body">
        <table id="ordertable" class="table table-hover table-responsive" style="vertical-align: top">
            <thead>
            <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Cost</th>
            </tr>
            </thead>
            <tbody>

            @foreach($order->details as $detail)
                <tr>
                <td>
                    {{$detail['item']}}
                </td>
                <td>
                    {{$detail['quantity']}}
                </td>
                <td>
                    {{ $detail['cost'] }}
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="box-footer">
        <div class="btn-group">
            <a href="{{ route('shopping.confirm', ['action'=>'Confirm', 'order_id'=>$order->order_id]) }}" class="btn btn-md btn-success">Confirm</a>
            <a href="{{ route('shopping.confirm', ['action'=>'Cancel', 'order_id'=>$order->order_id]) }}"  class="btn btn-md btn-danger">Cancel</a>
        </div>
    </div>
</div>
@endsection