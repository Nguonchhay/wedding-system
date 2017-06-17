<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $expense->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $expense->title !!}</p>
</div>

<!-- Dollar Field -->
<div class="form-group">
    {!! Form::label('dollar', 'Dollar:') !!}
    <p>{!! $expense->dollar !!}</p>
</div>

<!-- Khmer Field -->
<div class="form-group">
    {!! Form::label('khmer', 'Khmer:') !!}
    <p>{!! $expense->khmer !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $expense->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $expense->updated_at !!}</p>
</div>

