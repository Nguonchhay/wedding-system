<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('wedding_id', 'Wedding:') !!}
        {!! Form::select('wedding_id', $weddings, $selectedWedding, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('total', 'Total:') !!}
        {!! Form::text('total', null, ['class' => 'form-control only-digit', 'maxlength' => 10]) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('currency', 'Currency:') !!}
        {!! Form::select('currency', config('settings.expense.currencies'), $selectedCurrency, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('note', 'Note:') !!}
        {!! Form::textarea('note', null, ['class' => 'form-control textarea-aloha']) !!}
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('expenses.index') !!}" class="btn btn-default">Cancel</a>
</div>
