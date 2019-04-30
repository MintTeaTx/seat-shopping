@extends('web::layouts.grids.12')
@section('title','Detail View')
@section('page_header', 'Work In Progress')

@section('full')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"> Order List</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-xs btn-box-tool" id="createOrder" data-toggle="modal" data-target="#newOrderModal">
                    <span class="fa fa-plus-square"></span>
                </button>
            </div>
        </div>
        <div>
            <div class="box-body">
                @include('shopping::partials.orderdetails')
            </div>
        </div>
    </div>
