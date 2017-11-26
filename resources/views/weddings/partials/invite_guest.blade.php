@if($guests)
<div class="form-group col-sm-8">
    <table class="table table-responsive list-data">
        <thead>
            <th>
                {!! Form::checkbox('all', 1, false, ['class' => 'checkbox-all-guest']) !!}
                 All guests
            </th>
            <th>Khmer name</th>
            <th>English name</th>
        </thead>
        <tbody>
            @foreach($guests as $key => $guest)
                <tr>
                    <td>
                        {!! Form::checkbox('guests[]', $guest->id, false, ['class' => 'checkbox-guest']) !!}
                    </td>
                    <td>{!! $guest->khmer_name !!}</td>
                    <td>{!! $guest->english_name !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p>There is no guest to invite.</p>
@endif