{{-- AP Top Header --}}
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li  class="dropdown" id="profile-messages">
            <a href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="fa fa-user"></i>&nbsp;&nbsp;<span class="text">Welcome {{ Auth::user()->name }}</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('profiles.show', Auth::user()->id) }}"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
            </ul>
        </li>
        <li class=""><a href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;<span class="text">Settings</span></a></li>
        <li class=""><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;<span class="text">Logout</span></a></li>
    </ul>
</div>

{{-- AP Top Header Search --}}
<div id="search">
    <input type="text" placeholder="Search here...">
    <button type="submit" class="tip-bottom" title="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
</div>