@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>New Guest Group</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => 'guest_groups.store']) !!}
                @include('guest_groups.partials.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
