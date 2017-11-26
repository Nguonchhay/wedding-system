<table class="table table-responsive list-data" id="guests-table">
    <thead>
        <th>No</th>
        <th>Role</th>
        <th>Name</th>
        <th>Email</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($users as $key => $user)
        <tr>
            <td>{!! $key + 1 !!}</td>
            <td>{!! config('settings.roles.' . $user->role) !!}</td>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>