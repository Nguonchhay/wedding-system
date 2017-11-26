<div class="weddings">
    @if (count($weddings))
        @foreach($weddings as $wedding)
            <div class="item">
                <div class="action">
                    {!! Form::open(['route' => ['weddings.destroy', $wedding->id], 'method' => 'delete']) !!}
                        <a href="{!! route('wedding_invitations.index', [$wedding->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="glyphicon glyphicon-book"></i> Wedding book
                        </a>

                        <a href="{!! route('wedding_invitations.record', [$wedding->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="glyphicon glyphicon-gift"></i> Wedding record
                        </a>

                        @if(!Auth::user()->hasRole('user'))
                            <a href="{!! route('weddings.invite', [$wedding->id]) !!}" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-user"></i> Invite guests
                            </a>

                            <a href="{!! route('weddings.edit', [$wedding->id]) !!}" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endif
                    {!! Form::close() !!}
                </div>

                <div class="date">
                    {!! $wedding->title !!}
                    <strong>{!! \App\Utility\DateFormat::getFormatDate($wedding->start_date, 'd-m-Y') !!} - {!! \App\Utility\DateFormat::getFormatDate($wedding->end_date, 'd-m-Y') !!}</strong>
                </div>

                <div class="row">
                    <div class="col-xs-5">
                        <div class="preview">
                            <div class="image">
                                <img src="{!! asset($wedding->groom_image) !!}" />
                            </div>
                            <div class="name">{!! $wedding->groom_name !!}</div>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="heart">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <span>with</span>
                        </div>
                    </div>

                    <div class="col-xs-5">
                        <div class="preview">
                            <div class="image">
                                <img src="{!! asset($wedding->bride_image) !!}" />
                            </div>
                            <div class="name">{!! $wedding->bride_name !!}</div>
                        </div>
                    </div>
                </div>

                <div class="description">
                    {!! $wedding->note !!}
                </div>
            </div>

            <hr>
        @endforeach
    @else
        <strong>There is no wedding part yet.</strong>
    @endif
</div>