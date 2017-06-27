<li class="@if($activeMenu['active'] == 'home') active @endif">
    <a href="{!! url('/') !!}">
        <i class="fa fa-bars" aria-hidden="true"></i> <span>Dashboard</span>
    </a>
</li>

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

<li class="@if($activeMenu['active'] == 'wedding') active @endif">
    <a href="{!! url('/weddings') !!}">
        <i class="fa fa-book" aria-hidden="true"></i> <span>Wedding Party</span>
    </a>
</li>

<li class="@if($activeMenu['active'] == 'expense') active @endif">
    <a href="{!! url('/expenses') !!}">
        <i class="fa fa-users" aria-hidden="true"></i> <span>Wedding Expenses</span>
    </a>
</li>

<li class="@if($activeMenu['active'] == 'guests') active @endif">
    <a href="{!! url('/guests') !!}">
        <i class="fa fa-users" aria-hidden="true"></i> <span>Reports</span>
    </a>
</li>