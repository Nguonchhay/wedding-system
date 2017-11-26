@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Recording wedding gift of <strong>{!! $wedding->title !!}</strong></h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <form class="form">
                    {{ csrf_field() }}
                    @include('wedding_invitations.partials.recording_form')

                    <div class="form-group col-xs-6">
                        <a href="{!! route('weddings.index') !!}" class="btn btn-default">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to wedding list
                        </a>

                        <button type="button" id="btnWeddingRecordAjax" class="btn btn-primary" data-action="{!! route('wedding_invitations.record_ajax', ['id' => $wedding->id]) !!}">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                    </div>

                    <div class="col-xs-6">
                        <strong class="message"></strong>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

