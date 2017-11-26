@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Edit wedding gift @if($weddingInvitation->guest) of {!! $weddingInvitation->guest->khmer_name !!}@endif</h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               {!! Form::model($weddingInvitation, ['route' => ['wedding_invitations.update', $weddingInvitation->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
                    @include('wedding_invitations.partials.fields')
                    @include('partials.save_edit_action', ['route' => route('wedding_invitations.index', [$weddingInvitation->wedding->id])])
               {!! Form::close() !!}
           </div>
       </div>
   </div>
@endsection