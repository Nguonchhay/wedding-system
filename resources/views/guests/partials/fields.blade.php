{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            @include('guests.partials.guest_group_select')
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('khmer_name', 'Khmer name:') !!}
            {!! Form::text('khmer_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('english_name', 'English name:') !!}
            {!! Form::text('english_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('phone', 'Phone:') !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('print_name', 'Print Name:') !!}
            {!! Form::text('print_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            {!! Form::label('addres', 'Address:') !!}
            {!! Form::textarea('address', null, ['class' => 'form-control textarea-aloha']) !!}
        </div>
    </div>
</div>