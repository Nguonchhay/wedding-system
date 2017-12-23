<table class="table table-responsive list-data">
    <thead>
        <th>No</th>
        <th>Group</th>
        <th>Khmer name</th>
        <th>English name</th>
        <th>Phone number</th>
        <th>Print Name</th>
        <th>Address</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach($guests as $key => $guest)
        <tr>
            <td>{!! $key + 1 !!}</td>
            <td>
                @if($guest->guest_group)
                    {!! $guest->guest_group->name !!}
                @endif
            </td>
            <td>{!! $guest->khmer_name !!}</td>
            <td>{!! $guest->english_name !!}</td>
            <td>{!! $guest->phone !!}</td>
            <td>{!! $guest->print_name !!}</td>
            <td>{!! $guest->address !!}</td>
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