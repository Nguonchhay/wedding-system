@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Edit expense Detail</h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               {!! Form::model($expenseDetail, ['route' => ['expense_details.update', $expenseDetail->id], 'method' => 'patch']) !!}
                    @include('expense_details.partials.fields')
               {!! Form::close() !!}
           </div>
       </div>
   </div>
@endsection