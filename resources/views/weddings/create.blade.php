@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>New Wedding</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => 'weddings.store', 'enctype' => 'multipart/form-data']) !!}

                @include('weddings.partials.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
