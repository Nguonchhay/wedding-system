@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>New Expense</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => 'expenses.store']) !!}
                    @include('expenses.partials.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
