<table class="table table-responsive" id="expenses-table">
    <thead>
        <th>Title</th>
        <th>Dollar</th>
        <th>Khmer</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($expenses as $expense)
        <tr>
            <td>{!! $expense->title !!}</td>
            <td>{!! $expense->dollar !!}</td>
            <td>{!! $expense->khmer !!}</td>
            <td>
                {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('expenses.show', [$expense->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('expenses.edit', [$expense->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>