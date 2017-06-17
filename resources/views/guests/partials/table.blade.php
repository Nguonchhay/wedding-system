<table class="table table-responsive" id="guests-table">
    <thead>
        <th>Fullname</th>
        <th>Print Name</th>
        <th>Note</th>
        <th>Dollar</th>
        <th>Khmer</th>
        <th>Bat</th>
        <th>Dong</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($guests as $guest)
        <tr>
            <td>{!! $guest->fullname !!}</td>
            <td>{!! $guest->print_name !!}</td>
            <td>{!! $guest->note !!}</td>
            <td>{!! $guest->dollar !!}</td>
            <td>{!! $guest->khmer !!}</td>
            <td>{!! $guest->bat !!}</td>
            <td>{!! $guest->dong !!}</td>
            <td>
                {!! Form::open(['route' => ['guests.destroy', $guest->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('guests.show', [$guest->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('guests.edit', [$guest->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>