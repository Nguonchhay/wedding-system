@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Edit Guest Group</h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               {!! Form::model($guestGroup, ['route' => ['guest_groups.update', $guestGroup->id], 'method' => 'patch']) !!}
                    @include('guest_groups.partials.fields')
               {!! Form::close() !!}
           </div>
       </div>
   </div>
@endsection