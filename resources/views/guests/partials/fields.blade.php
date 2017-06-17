<!-- Fullname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fullname', 'Fullname:') !!}
    {!! Form::text('fullname', null, ['class' => 'form-control']) !!}
</div>

<!-- Print Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('print_name', 'Print Name:') !!}
    {!! Form::text('print_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control']) !!}
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

<!-- Bat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bat', 'Bat:') !!}
    {!! Form::text('bat', null, ['class' => 'form-control']) !!}
</div>

<!-- Dong Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dong', 'Dong:') !!}
    {!! Form::text('dong', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('guests.index') !!}" class="btn btn-default">Cancel</a>
</div>
