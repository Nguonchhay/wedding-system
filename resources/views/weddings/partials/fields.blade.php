<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start date:') !!}
    <div class="input-group date" id="start_date">
        <input type="text" class="form-control date-picker" id="start_date_" name="start_date" value="@if(isset($wedding)){{ $wedding->start_date }}@endif" placeholder="day-month-year">
        <span class="input-group-addon">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End date:') !!}
    <div class="input-group date" id="end_date">
        <input type="text" class="form-control date-picker" id="end_date_" name="end_date" value="@if(isset($wedding)){{ $wedding->end_date }}@endif" placeholder="day-month-year">
        <span class="input-group-addon">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('groom_name', 'Groom name:') !!}
    {!! Form::text('groom_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('bride_name', 'Bride name:') !!}
    {!! Form::text('bride_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('guests.index') !!}" class="btn btn-default">Cancel</a>
</div>
