<li class="@if($activeMenu['active'] == 'home') active @endif">
    <a href="{!! url('/') !!}">
        <i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span>
    </a>
</li>

@if(!Auth::user()->hasRole('user'))
    <li class="@if($activeMenu['active'] == 'guest_group') active @endif">
        <a href="{!! url('/guest_groups') !!}">
            <i class="fa fa-users" aria-hidden="true"></i> <span>Guest Group</span>
        </a>
    </li>

    <li class="@if($activeMenu['active'] == 'guest') active @endif">
        <a href="{!! url('/guests') !!}">
            <i class="fa fa-users" aria-hidden="true"></i> <span>Guests</span>
        </a>
    </li>
@endif

<li class="@if($activeMenu['active'] == 'wedding') active @endif">
    <a href="{!! url('/weddings') !!}">
        <i class="fa fa-heart" aria-hidden="true"></i> <span>Wedding Party</span>
    </a>
</li>

@if(!Auth::user()->hasRole('user'))
    <li class="@if($activeMenu['active'] == 'expense') active @endif">
        <a href="{!! url('/expenses') !!}">
            <i class="fa fa-money" aria-hidden="true"></i> <span>Wedding Expenses</span>
        </a>
    </li>

    <li class="@if($activeMenu['active'] == 'user') active @endif">
        <a href="{!! url('/users') !!}">
            <i class="fa fa-users" aria-hidden="true"></i> <span>Users</span>
        </a>
    </li>
@endif