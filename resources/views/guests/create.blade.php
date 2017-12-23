@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>New Guess</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'guests.store']) !!}
                        @include('guests.partials.fields')

                        @if($weddings)
                            <div class="form-group">
                                <div class="col-xs-3">
                                    {!! Form::checkbox('is_invite', 1, false, ['id' => 'isInviteImportingGuest']) !!}
                                    {!! Form::label('isInviteImportingGuest', 'invite to wedding') !!}
                                </div>

                                @include('guests.partials.wedding_select')
                                <br>
                            </div>
                        @endif

                        @include('partials.save_edit_action', ['route' => route('guests.index')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
