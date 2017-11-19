<table class="table table-responsive" id="guests-table">
    <thead>
        <th>No</th>
        <th>Full name</th>
        <th>Print Name</th>
        <th>Note</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($guests as $key => $guest)
        <tr>
            <td>{!! $key + 1 !!}</td>
            <td>{!! $guest->full_name !!}</td>
            <td>{!! $guest->print_name !!}</td>
            <td>{!! $guest->note !!}</td>
            <td>
                {!! Form::open(['route' => ['guests.destroy', $guest->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('guests.edit', [$guest->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>