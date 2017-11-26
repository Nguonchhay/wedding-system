<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('dollar', 'Dollar:') !!}
        {!! Form::text('dollar', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('khmer', 'Riel:') !!}
        {!! Form::text('khmer', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('other', 'other:') !!}
        {!! Form::textarea('other', null, ['size' => '50 x 2', 'class' => 'form-control']) !!}
    </div>
</div>