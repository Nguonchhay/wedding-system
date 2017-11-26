@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Invited guests of wedding <strong>{!! $wedding->title !!}</strong></h1>
        @if(!Auth::user()->hasRole('user'))
            <div class="pull-right">
               <a class="btn btn-primary" style="margin-top: -10px; margin-bottom: 5px" href="{!! route('weddings.invite', ['id' => $wedding->id]) !!}">Invite more guests</a>
            </div>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('wedding_invitations.partials.table')

                <div class="form-group col-sm-12">
                    <a href="{!! route('weddings.index') !!}" class="btn btn-default">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to wedding list
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

