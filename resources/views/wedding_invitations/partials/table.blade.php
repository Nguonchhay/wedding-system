<div class="form-group col-sm-12">
    <table class="table table-responsive list-data12" id="weddingBook">
        <thead>
            <th>No</th>
            <th>Group name</th>
            <th>Khmer name</th>
            <th>English name</th>
            <th>Dollar</th>
            <th>Khmer</th>
            <th>Other</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($weddingInvitations as $key => $weddingInvitation)
                @if($weddingInvitation->guest)
                    <tr>
                        <td>{!! $key + 1 !!}</td>
                        <td>{!! $weddingInvitation->guest->guest_group->name !!}</td>
                        <td>{!! $weddingInvitation->guest->khmer_name !!}</td>
                        <td>{!! $weddingInvitation->guest->english_name !!}</td>
                        <td class="gift-dollar">{!! ($weddingInvitation->dollar > 0) ? $weddingInvitation->dollar : '' !!}</td>
                        <td class="gift-khmer">{!! ($weddingInvitation->khmer > 0) ? $weddingInvitation->khmer : '' !!}</td>
                        <td>{!! $weddingInvitation->other !!}</td>
                        <td>
                            {!! Form::open(['route' => ['wedding_invitations.destroy', $weddingInvitation->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! route('wedding_invitations.edit', [$weddingInvitation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>

                                @if($weddingInvitation->dollar == 0.0 && $weddingInvitation->khmer == 0)
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                @endif
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>