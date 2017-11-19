@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Edit User</h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch', 'id' => 'formUserEdit']) !!}
                        @include('users.partials.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection