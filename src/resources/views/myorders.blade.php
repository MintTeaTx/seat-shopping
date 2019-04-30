@extends('web::layouts.grids.12')
@section('title','My Orders')
@section('page_header', 'Work In Progress')

@section('full')
     <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"> My Orders</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-xs btn-box-tool" id="createOrder" data-toggle="modal" data-target="#newOrderModal">
                    <span class="fa fa-plus-square"></span>
                </button>
            </div>
        </div>
        <div>
             <div class="box-body">
                 <div class="nav-tabs-custom">
                     <ul class="nav nav-tabs">
                         <li class="active"><a href="#pendingTab" data-toggle="tab">Pending Orders</a></li>
                         <li><a href="#completedTab" data-toggle="tab">Completed Orders</a></li>
                         <li><a href="#rejectedTab" data-toggle="tab">Rejected Orders</a></li>
                         <li><a href="#progressTab" data-toggle="tab">Orders In Progress</a></li>

                     </ul>
                     <div class="tab-content">
                         <div class="tab-pane active" id="pendingTab">

                             <table id="pendingTable" class="table table-bordered">
                                 <thead>
                                 <tr>
                                     <th>Order ID</th>
                                     <th>Payment Status</th>
                                     <th>Total Cost</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @if(count($pending) > 0)
                                     @foreach($pending as $order)
                                         @if($order->status === 0)
                                             <tr>
                                                 <td>
                                                     <a href="{{ route('shopping.orderView', ['order_id' => $order->order_id]) }}" >{{ $order->order_id }}</a>
                                                 </td>
                                                 <td>
                                                     @if($order->is_paid)
                                                         Paid!
                                                     @else
                                                         Not Paid!  Give the total to the corp and paste [  Order {{$order->order_id}}  ] into the reason.
                                                     @endif
                                                 </td>
                                                 <td>
                                                     {{ number_format( $order->total_cost )}} ISK
                                                 </td>

                                             </tr>
                                         @endif
                                     @endforeach
                                 @endif
                                 </tbody>
                             </table>
                         </div>
                         <div class="tab-pane" id="completedTab">
                             <table id="completedTable" class="table table-bordered">
                                 <thead>
                                 <tr>
                                     <th>Order ID</th>
                                     <th>Delivered Date</th>
                                     <th>Total Cost</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @if(count($complete) > 0)
                                     @foreach($complete as $order)
                                         @if($order->status === 2)
                                             <tr>
                                                 <td>
                                                     <a href="{{ route('shopping.orderView', ['order_id' => $order->order_id]) }}" >{{ $order->order_id }}</a>
                                                 </td>
                                                 <td>
                                                     {{ $order->completed_date }}
                                                 </td>
                                                 <td>
                                                     {{ number_format( $order->total_cost )}} ISK
                                                 </td>

                                             </tr>
                                         @endif
                                     @endforeach
                                 @endif
                                 </tbody>
                             </table>
                         </div>
                         <div class="tab-pane" id="progressTab">
                            <table id="progressTable" class="table table-bordered">
                                 <thead>
                                 <tr>
                                     <th>Order ID</th>
                                     <th>Updated On</th>
                                     <th>Total Cost</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @if(count($progress) > 0)
                                     @foreach($progress as $order)
                                         @if($order->status === 1)
                                             <tr>
                                                 <td>
                                                     <a href="{{ route('shopping.orderView', ['order_id' => $order->order_id]) }}" >{{ $order->order_id }}</a>
                                                 </td>
                                                 <td>
                                                     {{ $order->updated_at }}
                                                 </td>
                                                 <td>
                                                     {{ number_format( $order->total_cost )}} ISK
                                                 </td>

                                             </tr>
                                         @endif
                                     @endforeach
                                 @endif
                                 </tbody>
                             </table>
                         </div>
                         <div class="tab-pane" id="rejectedTab">
                             <table id="rejectedTable" class="table table-bordered">
                                 <thead>
                                 <tr>
                                     <th>Order ID</th>
                                     <th>Rejected On</th>
                                     <th>Reason</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @if(count($rejected) > 0)
                                     @foreach($rejected as $order)
                                         @if($order->status === -1)
                                             <tr>
                                                 <td>
                                                     <a href="{{ route('shopping.orderView', ['order_id' => $order->order_id]) }}" >{{ $order->order_id }}</a>
                                                 </td>
                                                 <td>
                                                     {{ $order->updated_at }}
                                                 </td>
                                                 <td>
                                                     {{ $order->reason }}
                                                 </td>

                                             </tr>
                                         @endif
                                     @endforeach
                                 @endif
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
        </div>

     </div>
@endsection
@include('shopping::includes.neworder')
