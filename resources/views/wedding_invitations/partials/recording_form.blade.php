<div class="form-group col-sm-12">
    {!! Form::label('select_guest', 'Select guest:') !!}
    <select id="weddingInvitation" name="guest" required class="form-control selectpicker" data-live-search="true">
        <option value="" data-tokens="">Please select guest</option>
        @foreach ($weddingInvitations as $weddingInvitation)
            <option value="{{ $weddingInvitation->id }}" data-tokens="{!! $weddingInvitation->khmer_name !!},{!! $weddingInvitation->english_name !!},{!! $weddingInvitation->phone !!},{!! $weddingInvitation->address !!},{!! $weddingInvitation->print_name !!}">{!! $weddingInvitation->displayGuestInfo !!}</option>
        @endforeach
    </select>
</div>

<div class="form-group row">
    <div class="col-sm-12">
        <div class=" col-sm-6">
            <label for="gift_dollar">Dollar (<i class="fa fa-usd" aria-hidden="true"></i>)</label>
            {!! Form::text('dollar', null, ['class' => 'form-control gif-recording', 'id' => 'gift_dollar']) !!}
        </div>

        <div class="col-sm-6">
            <label for="gift_khmer">Riel (<i class="fa fa-money" aria-hidden="true"></i>)</label>
            {!! Form::text('khmer', null, ['class' => 'form-control gif-recording', 'id' => 'gift_khmer']) !!}
        </div>

        <div class="col-sm-12">
            {!! Form::label('gift_other', 'Other gift:') !!}
            {!! Form::textarea('other', null, ['size' => '50 x 2', 'class' => 'form-control ', 'id' => 'gift_other']) !!}
        </div>
    </div>
</div>