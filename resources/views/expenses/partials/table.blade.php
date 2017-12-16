<table id="expenseTable" class="table table-bordered table-striped list-data">
    <thead>
        <tr>
            <th style="width: 20px;">No</th>
            <th>Wedding</th>
            <th>Title</th>
            <th>Dollar</th>
            <th>Khmer</th>
            <th style="width: 150px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $key => $expense)
            <tr>
                <td>{!! $key + 1 !!}</td>
                <td>
                    {!! $expense->wedding->title !!}

                   @if(!$expense->expense_details->isEmpty())
                        | <a href="#" class="" data-toggle="modal" data-target="#{!! $expense->id !!}">
                            <i class="fa fa-eye"></i> Expense details
                        </a>

                        <div id="{!! $expense->id !!}" class="modal fade" role="dialog">
                            <div class="modal-dialog" style="width: 60%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Detail expense of  <strong>{!! $expense->title !!}</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th style="width: 20px;">No</th>
                                                <th style="width: 80px;">Date</th>
                                                <th style="width: 200px;">Who is expense?</th>
                                                <th style="width: 80px;">Dollar</th>
                                                <th style="width: 80px;">Khmer</th>
                                                <th>Note</th>
                                                <th style="width: 20px;">
                                                    <a href="{!! url('expense_details/' . $expense->id . '/create') !!}"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> New</a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($expense->expense_details as $key => $expense_detail)
                                                    <tr>
                                                        <td>{!! $key + 1 !!}</td>
                                                        <td>{!! date('Y-m-d', strtotime($expense_detail->date)) !!}</td>
                                                        <td>{!! $expense_detail->who !!}</td>
                                                        <td>{!! $expense_detail->dollar !!}</td>
                                                        <td>{!! $expense_detail->khmer !!}</td>
                                                        <td>{!! $expense_detail->note !!}</td>
                                                        <td style="width: 50px;">
                                                            {!! Form::open(['route' => ['expense_details.destroy', $expense_detail->id], 'method' => 'delete']) !!}
                                                            <div class='btn-group'>
                                                                <a title="Edit" href="{!! route('expense_details.edit', [$expense_detail->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        Total dollar: <strong>${!! $expense->getTotalExpense()['total_dollar'] !!}</strong>,
                                        khmer: <strong>{!! $expense->getTotalExpense()['total_khmer'] !!}</strong>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            <i class="fa fa-times"></i> Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   @endif
                </td>
                <td>{!! $expense->title !!}</td>
                <td>{!! $expense->getTotalExpense()['total_dollar'] !!}</td>
                <td>{!! $expense->getTotalExpense()['total_khmer'] !!}</td>
                <td>
                    {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! url('expense_details/' . $expense->id . '/create') !!}" class='btn btn-default btn-xs'><i class="fa fa-fw fa-plus" aria-hidden="true"></i> expense detail</a>
                        <a href="{!! route('expenses.edit', [$expense->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(count($expenses))
    <fieldset>
        <legend>Total expense by weddings</legend>
        <ul>
            @foreach($totalExpenses as $key => $totalExpense)
                <li>
                    {!! $key !!} : Dollar: <strong>{!! $totalExpense['total_dollar'] !!}</strong>, Khmer: <strong>{!! $totalExpense['total_khmer'] !!}</strong>
                </li>
            @endforeach
        </ul>
    </fieldset>
@endif