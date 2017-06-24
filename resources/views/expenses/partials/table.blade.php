<table id="expenseTable" class="table table-bordered table-striped list-data">
    <thead>
        <tr>
            <th>No</th>
            <th>Wedding</th>
            <th>Title</th>
            <th>Total</th>
            <th>Currency</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $key => $expense)
            <tr>
                <td>{!! $key + 1 !!}</td>
                <td>{!! $expense->wedding->groom_name !!}</td>
                <td>{!! $expense->title !!}</td>
                <td>{!! $expense->total !!}</td>
                <td>{!! ucfirst($expense->currency) !!}</td>
                <td>
                    {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('expenses.edit', [$expense->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>