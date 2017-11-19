{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            @include('guests.partials.guest_group_select')
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('khmer_full_name', 'Khmer full name:') !!}
            {!! Form::text('khmer_full_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('full_name', 'English full name:') !!}
            {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('print_name', 'Print Name:') !!}
            {!! Form::text('print_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            {!! Form::label('note', 'Note:') !!}
            {!! Form::textarea('note', null, ['class' => 'form-control textarea-aloha']) !!}
        </div>
    </div>
</div>

@include('partials.save_edit_action', ['route' => route('guests.index')])