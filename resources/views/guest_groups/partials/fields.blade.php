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

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('guest_groups.index') !!}" class="btn btn-default">Cancel</a>
</div>
