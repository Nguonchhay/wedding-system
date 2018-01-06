@if(isset($expense))
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('wedding_id', 'Wedding ', ['class' => 'required']) !!}
            {!! Form::select('wedding_id', $weddings, $selectedWedding, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="form-group col-sm-6">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
@else
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('wedding_id', 'Wedding ', ['class' => 'required']) !!}
            {!! Form::select('wedding_id', $weddings, $selectedWedding, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="form-group col-sm-6">
            {!! Form::label('date', 'Date ', ['class' => 'required']) !!}
            <div class="input-group date date-picker" id="date">
                <input type="text" class="form-control date-picker" id="date_" name="date" required value="@if(isset($expenseDetail)){{ $expenseDetail->date }}@endif" placeholder="year-month-day">
            <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="form-group col-sm-6">
            {!! Form::label('who', 'Who pay:') !!}
            {!! Form::text('who', null, ['class' => 'form-control']) !!}
        </div>

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
        <div class="form-group col-sm-12">
            {!! Form::label('note', 'Note:') !!}
            {!! Form::textarea('note', null, ['class' => 'form-control textarea-aloha', 'size' => '30x2']) !!}
        </div>
    </div>
@endif


@include('partials.save_edit_action', ['route' => route('expenses.index')])