<table class="table table-responsive" id="guestGroups-table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Short Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($guestGroups as $key => $guestGroup)
        <tr>
            <td>{!! $key + 1 !!}</td>
            <td>{!! $guestGroup->name !!}</td>
            <td>{!! $guestGroup->short_name !!}</td>
            <td>
                {!! Form::open(['route' => ['guest_groups.destroy', $guestGroup->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('guest_groups.edit', [$guestGroup->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>