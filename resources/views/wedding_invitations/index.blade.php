@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Wedding book of <strong>{!! $wedding->title !!}</strong></h1>
        @if(!Auth::user()->hasRole('user'))
            <div class="pull-right" style="margin-top: -10px; margin-bottom: 5px">
                <a class="btn btn-primary" href="{!! route('weddings.invite', ['id' => $wedding->id]) !!}">
                    <i class="fa fa-plus" aria-hidden="true"></i> Invite more guests
                </a>
            </div>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('wedding_invitations.partials.filter')
                @include('wedding_invitations.partials.table')

                <div class="form-group col-sm-12">
                    <ul>
                        <li>
                            Total dollar (<i class="fa fa-usd" aria-hidden="true"></i>): <strong id="totalDollar"></strong>
                        </li>
                        <li>
                            Total riel (<i class="fa fa-money" aria-hidden="true"></i>): <strong id="totalKhmer"></strong>
                        </li>
                    </ul>
                </div>

                <div class="form-group col-sm-12">
                    <a href="{!! route('weddings.index') !!}" class="btn btn-default">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to wedding list
                    </a>

                    <a class="btn btn-primary" href="{!! route('wedding_invitations.export_guest_list_excel', [$wedding->id]) !!}">
                        <i class="fa fa-download" aria-hidden="true"></i> Export guest name for wedding invitation letter
                    </a>

                    <a class="btn btn-primary" href="{!! route('wedding_invitations.export_wedding_book_excel', ['wedding_id' => $wedding->id, 'group' => $selectedGroup, 'gift_status' => $selectedGiftStatus]) !!}">
                        <i class="fa fa-download" aria-hidden="true"></i> Export guests by filter
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

