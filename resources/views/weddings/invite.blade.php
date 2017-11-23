@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Invite guests to <strong>{!! $wedding->title !!}</strong></h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::model($wedding, ['route' => ['weddings.invite_guest', $wedding->id], 'method' => 'post', 'id' => 'formInviteGuest']) !!}
                    @include('weddings.partials.invite_guest')
                    @include('partials.save_edit_action', ['route' => route('weddings.index')])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
