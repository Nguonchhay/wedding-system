{!! Form::label('guest_group', 'Guest group', ['class' => 'required']) !!}
{!! Form::select('guest_group_id', $guestGroups, (isset($selectedGuestGroup) ? $selectedGuestGroup : null), ['class' => 'form-control', 'id' => 'guest_group_']) !!}