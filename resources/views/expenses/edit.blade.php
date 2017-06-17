@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Expense
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($expense, ['route' => ['expenses.update', $expense->id], 'method' => 'patch']) !!}

                        @include('expenses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection