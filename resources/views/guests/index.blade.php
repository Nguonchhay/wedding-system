@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Guests</h1>
        <div class="pull-right">
            <div class='btn-group'>
                <a class="btn btn-primary" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('guests.import') !!}">
                    <i class="fa fa-upload" aria-hidden="true"></i> Import guests
                </a>

                @include('partials.new_action', ['route' => route('guests.create')])
            </div>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('guests.partials.filter')
                @include('guests.partials.table')
            </div>
        </div>
    </div>
@endsection

