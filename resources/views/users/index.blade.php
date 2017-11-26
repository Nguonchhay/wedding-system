@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Users</h1>
        <div class="pull-right">
            @include('partials.new_action', ['route' => route('users.create')])
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('users.partials.filter')
                @include('users.partials.table')
            </div>
        </div>
    </div>
@endsection

