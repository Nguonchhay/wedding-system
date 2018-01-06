<div class="filter">
    {!! Form::model(['route' => 'wedding_invitations.index'], ['method' => 'GET', 'class' => 'form-horizontal']) !!}
        <h3>Filter options:</h3>
        <div class="form-group">
            <div class="col-sm-4"
                <label>Group:</label>
                {!! Form::select('group', $guestGroups, $selectedGroup, ['class' => 'form-control', 'id' => 'guest_group_']) !!}
            </div>

            <div class="col-sm-4">
                <label>Gift status:</label>
                {!! Form::select('gift_status', config('settings.wedding_gifts'), $selectedGiftStatus, ['class' => 'form-control']) !!}
            </div>
        </div>



        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </button>
        </div>
    {!! Form::close() !!}
</div>