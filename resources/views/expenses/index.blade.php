@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Expenses</h1>
        <div class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('expenses.create') !!}">Add New</a>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('expenses.partials.table')
            </div>
        </div>
    </div>
@endsection

