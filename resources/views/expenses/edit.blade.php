@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Edit Expense</h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               {!! Form::model($expense, ['route' => ['expenses.update', $expense->id], 'method' => 'patch']) !!}
                    @include('expenses.partials.fields')
               {!! Form::close() !!}
           </div>
       </div>
   </div>
@endsection