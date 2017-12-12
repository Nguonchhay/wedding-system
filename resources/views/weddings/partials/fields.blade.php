{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('title', 'Wedding title:') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('start_date', 'Start date:') !!}
        <div class="input-group date date-picker" id="start_date">
            <input type="text" class="form-control date-picker" id="start_date_" name="start_date" value="@if(isset($wedding)){{ $wedding->start_date }}@endif" placeholder="year-month-day">
        <span class="input-group-addon">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('end_date', 'End date:') !!}
        <div class="input-group date date-picker" id="end_date">
            <input type="text" class="form-control date-picker" id="end_date_" name="end_date" value="@if(isset($wedding)){{ $wedding->end_date }}@endif" placeholder="year-month-day">
        <span class="input-group-addon">
            <i class="fa fa-calendar" aria-hidden="true"></i>
        </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('groom_name', 'Groom name:') !!}
        {!! Form::text('groom_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('bride_name', 'Bride name:') !!}
        {!! Form::text('bride_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        <label>Groom image</label>
        @if(isset($wedding) && $wedding->groom_image)
            <div class="existImage">
                <button class="btn btn-default btn-delete-image" type="button"><i class="fa fa-times"></i></button><br>
                <input type="hidden" class="store-delete" name="groomImageIsDelete" value="0">
                <img class="image-preview" src="{{ asset('/') . $wedding->groom_image }}" >
            </div><br>
            <input type="file" class="form-control hide image-preview-option" data-image-preview="new-image-preview" name="groom_image" accept="image/*">
            <img class="hide new-image-preview" src="#" alt="Preview image" />
        @else
            <input type="file" class="form-control image-preview-option" data-image-preview="image-preview" name="groom_image" accept="image/*">
            <img class="hide image-preview" src="#" alt="Preview image" />
        @endif
    </div>

    <div class="form-group col-sm-6">
        <label>Bride image</label>
        @if(isset($wedding) && $wedding->bride_image)
            <div class="existImage">
                <button class="btn btn-default btn-delete-image" type="button"><i class="fa fa-times"></i></button><br>
                <input type="hidden" class="store-delete" name="brideImageIsDelete" value="0">
                <img class="image-preview" src="{{ asset('/') . $wedding->bride_image }}" >
            </div><br>
            <input type="file" class="form-control hide image-preview-option" data-image-preview="new-image-preview" name="bride_image" accept="image/*">
            <img class="hide new-image-preview" src="#" alt="Preview image" />
        @else
            <input type="file" class="form-control image-preview-option" data-image-preview="image-preview" name="bride_image" accept="image/*">
            <img class="hide image-preview" src="#" alt="Preview image" />
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('note', 'Note:') !!}
        {!! Form::textarea('note', null, ['class' => 'form-control']) !!}
    </div>
</div>

@include('partials.save_edit_action', ['route' => route('weddings.index')])