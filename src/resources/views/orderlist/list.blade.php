@extends('web::layouts.grids.12')
@section('title','Order List')
@section('page_header', 'Work In Progress')

@section('full')
    <div class="box box-primary box-solid">
        <div class="box-header">
            @if($handler)
                <h3 class="box-title"> <span class="id-to-name" data-id="{{ $handler }}">{{ trans('web::seat.unknown') }}</span>'s Order List</h3>
            @else
                <h3 class="box-title"> Order List</h3>
            @endif
        </div>
        <div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @if(!$handler)
                        <li class="active"><a href="#pendingTab" data-toggle="tab">Pending Orders</a></li>
                        <li><a href="#progressTab" data-toggle="tab">Orders In Progress</a></li>
                        @else
                            <li class="active"><a href="#progressTab" data-toggle="tab">Orders In Progress</a></li>
                        @endif
                        <li><a href="#completedTab" data-toggle="tab">Completed Orders</a></li>
                        <li><a href="#rejectedTab" data-toggle="tab">Rejected Orders</a></li>


                    </ul>
                    <div class="tab-content">
                        @if(!$handler)
                        <div class="tab-pane active" id="pendingTab">

                            <table id="pendingTable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Character</th>
                                    <th>Placed On</th>
                                    <th>Total Cost</th>
                                    <th>Volume</th>
                                    <th>Is Paid?</th>
                                    <th>Actions</th>
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
                                                    {!! img('character', $order->user_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->user_id]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->user_id }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$order->created_at}}
                                                </td>
                                                <td>
                                                    {{ number_format( $order->total_cost )}} ISK
                                                </td>
                                                <td>
                                                    {{ number_format( $order->volume )}}m<sup>3</sup>
                                                </td>
                                                <td>
                                                    @if($order->is_paid)
                                                        Paid!
                                                    @else
                                                        Not Paid!
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{route('shopping.settle', ['action' => 'Progress', 'order_id' => $order->order_id]) }}"> Approve </a> |
                                                    <a href="{{route('shopping.rejectview', ['order_id' => $order->order_id]) }}"> Reject </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="progressTab">

                        @else
                        <div class="tab-pane active" id="progressTab">
                            @endif
                            <table id="progressTable" class="table table-bordered">

                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Character</th>
                                    <th>Total Cost</th>
                                    <th>Volume</th>
                                    <th>Updated On</th>
                                    <th>Actions</th>
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
                                                    {!! img('character', $order->user_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->user_id]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->user_id }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! img('character', $order->handler, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->handler]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->handler }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ number_format( $order->total_cost )}} ISK
                                                </td>
                                                <td>
                                                    {{ number_format( $order->volume )}}m<sup>3</sup>
                                                </td>
                                                <td>
                                                    {{$order->updated_at}}
                                                </td>
                                                <td>
                                                    <a href="{{route('shopping.settle', ['action' => 'Complete', 'order_id' => $order->order_id]) }}"> Mark Complete </a>
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
                                    <th>Placed By</th>
                                    <th>Handler</th>
                                    <th>Total Cost</th>
                                    <th>Volume</th>
                                    <th>Completed On</th>
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
                                                    {!! img('character', $order->user_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->user_id]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->user_id }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! img('character', $order->handler, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->handler]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->handler }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ number_format( $order->total_cost )}} ISK
                                                </td>
                                                <td>
                                                    {{ number_format( $order->volume )}}m<sup>3</sup>
                                                </td>
                                                <td>
                                                    {{$order->completed_date}}
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
                                    <th>Character</th>
                                    <th>Placed On</th>
                                    <th>Total Cost</th>
                                    <th>Volume</th>
                                    <th>Rejected By</th>
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
                                                    {!! img('character', $order->user_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->user_id]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->user_id }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$order->created_at}}
                                                </td>
                                                <td>
                                                    {{ number_format( $order->total_cost )}} ISK
                                                </td>
                                                <td>
                                                    {{ number_format( $order->volume )}}m<sup>3</sup>
                                                </td>
                                                <td>
                                                    {!! img('character', $order->handler, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                                                    <a href="{{ route('character.view.sheet', ['character_id' => $order->handler]) }}">
                                                        <span class="id-to-name" data-id="{{ $order->handler }}">{{ trans('web::seat.unknown') }}</span>
                                                    </a>
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
    </div>
@endsection
@include('shopping::includes.neworder')
@push('javascript')
    @include('web::includes.javascript.id-to-name')
@endpush
