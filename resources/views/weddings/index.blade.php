@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Weddings</h1>
        @if(!Auth::user()->hasRole('user'))
            <div class="pull-right">
                @include('partials.new_action', ['route' => route('weddings.create')])
            </div>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('weddings.partials.table')
            </div>
        </div>
    </div>
@endsection

