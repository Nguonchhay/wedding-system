@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Import Guests</h1>
    </section>
    <div class="content">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => 'guests.import_guest', 'enctype' => 'multipart/form-data', 'id' => 'formUploadGuest']) !!}
                    <div class="form-group col-sm-12">
                        {!! Form::label('file', 'Imprt excel file (.xlsx)') !!}
                        <input type="file" required class="form-control" name="import_file" accept=".xlsx">

                        @include('guests.partials.sample_excel')
                    </div>

                    @if($weddings)
                        <div class="form-group row">
                            <div class="col-xs-3">
                                {!! Form::checkbox('is_invite', 1, false, ['id' => 'isInviteImportingGuest']) !!} <label for="isInviteImportingGuest">inviting all importing guests</label>
                            </div>

                            @include('guests.partials.wedding_select')
                        </div>
                    @endif

                    @include('partials.save_edit_action', ['route' => route('guests.index')])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

