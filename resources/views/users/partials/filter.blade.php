<div class="filter">
    {!! Form::model(['route' => 'users.index'], ['method' => 'GET', 'class' => 'form-horizontal']) !!}
        <h3>Filter users:</h3>
        <div class="form-group col-sm-12">
            <label>Role:</label>
            {!! Form::select('role', $userRoles, $selectedRole, ['class' => 'form-control col-xs-4', 'id' => 'role']) !!}
        </div>

        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </button>
        </div>
    {!! Form::close() !!}
</div>