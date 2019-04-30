@extends('web::layouts.grids.12')
@section('title', 'Order Confirmation')
@section('page_header', 'Dicks out for Harambe')

@section('full')
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"> Order Confirmation</h3>
    </div>
    <div class="box-body">
    @include('shopping::partials.orderdetails')
        
    </div>
    <div class="box-footer">
        <div class="btn-group">
            <a href="{{ route('shopping.myorders') }}" class="btn btn-md btn-success">Confirm</a>
            <a href="{{ route('shopping.cancel', ['order_id'=>$order->order_id]) }}"  class="btn btn-md btn-danger">Cancel</a>
        </div>
    </div>
</div>
@endsection