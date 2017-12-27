@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Guest Groups</h1>
        <div class="pull-right">
            @include('partials.new_action', ['route' => route('guest_groups.create')])
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('guest_groups.partials.table')
            </div>
        </div>
    </div>
@endsection

