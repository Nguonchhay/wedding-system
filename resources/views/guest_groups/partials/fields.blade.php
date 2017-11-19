<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('short_name', 'Short Name:') !!}
        {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

@include('partials.save_edit_action', ['route' => route('guest_groups.index')])