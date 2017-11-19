@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>User detail</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @include('users.partials.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
