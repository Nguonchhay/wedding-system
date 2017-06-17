<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Dollar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dollar', 'Dollar:') !!}
    {!! Form::text('dollar', null, ['class' => 'form-control']) !!}
</div>

<!-- Khmer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('khmer', 'Khmer:') !!}
    {!! Form::text('khmer', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('expenses.index') !!}" class="btn btn-default">Cancel</a>
</div>
