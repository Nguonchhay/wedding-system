@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Guess
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($guest, ['route' => ['guests.update', $guest->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                        @include('guests.partials.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection