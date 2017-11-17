@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Expense Detail: {!! $selectedExpense->title !!}</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => 'expense_details.store']) !!}
                    @include('expense_details.partials.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
