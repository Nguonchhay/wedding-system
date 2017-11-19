<div class="filter">
    {!! Form::model(['route' => 'guests.index'], ['method' => 'GET', 'class' => 'form-horizontal']) !!}
        <h3>Filter guests:</h3>
        <div class="form-group col-sm-12">
            <label>Group:</label>
            {!! Form::select('group', $guestGroups, $selectedGroup, ['class' => 'form-control col-xs-4', 'id' => 'guest_group_']) !!}
        </div>

        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </button>
        </div>
    {!! Form::close() !!}
</div>