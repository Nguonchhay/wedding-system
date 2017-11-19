{!! Form::label('role', 'Role', ['class' => 'required']) !!}
{!! Form::select('role', $userRoles, (isset($selectedRole) ? $selectedRole : null), ['class' => 'form-control', 'id' => 'role']) !!}