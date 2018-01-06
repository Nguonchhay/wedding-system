<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('expense_title', 'Expense ', ['class' => 'required']) !!}
        {!! Form::text('expense_id', $selectedExpense->id, ['class' => 'form-control hidden']) !!}
        {!! Form::text('expense_title', $selectedExpense->title, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('date', 'Date ', ['class' => 'required']) !!}
        <div class="input-group date date-picker" id="date">
            <input type="text" class="form-control date-picker" id="date_" name="date" required value="@if(isset($expenseDetail)){{ $expenseDetail->date }}@endif" placeholder="year-month-day">
            <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('who', 'Who pay:') !!}
        {!! Form::text('who', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('dollar', 'Dollar:') !!}
        {!! Form::text('dollar', null, ['class' => 'form-control only-digit', 'maxlength' => 5]) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('khmer', 'Khmer:') !!}
        {!! Form::text('khmer', null, ['class' => 'form-control only-digit', 'maxlength' => 10]) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12 col-lg-12">
        {!! Form::label('note', 'Note:') !!}
        {!! Form::textarea('note', null, ['class' => 'form-control textarea-aloha']) !!}
    </div>
</div>

@include('partials.save_edit_action', ['route' => route('expenses.index')])