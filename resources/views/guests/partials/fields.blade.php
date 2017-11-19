{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="form-group col-sm-12">
    @include('guests.partials.guest_group_select')
</div>

<div class="form-group col-sm-6">
    {!! Form::label('full_name', 'Full name:') !!}
    {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('print_name', 'Print Name:') !!}
    {!! Form::text('print_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control textarea-aloha']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('guests.index') !!}" class="btn btn-default">Cancel</a>
</div>
