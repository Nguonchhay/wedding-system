<div class="form-group col-sm-12">
    {!! Form::label('role', 'Role') !!}
    {!! Form::text('role', $user->role, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', $user->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
        </div>
    </div>
</div>

<div class="form-group col-sm-12">
    <a href="{!! route('users.index') !!}" class="btn btn-default">
        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to list
    </a>

    <a class="btn btn-primary" href="{!! route('users.edit', ['id' => $user->id]) !!}">
        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
    </a>
</div>
