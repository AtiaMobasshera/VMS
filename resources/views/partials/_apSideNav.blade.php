    {{-- AP Side Nav --}}
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-file"></i> Addons</a>
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i><span> Dashboard</span></a></li>
            <li class="{{ Request::is('inbox') ? 'active' : '' }}"><a href="{{ route('inbox.index') }}"><i class="fa fa-inbox" aria-hidden="true"></i> <span>Inbox</span></a></li>

            @if(Auth::user()->role=='admin')
            <li class="submenu {{ Request::is('visitreasons') ? 'active' : Request::is('visitreasons/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-map-signs" aria-hidden="true"></i> <span>Visit Reasons</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('visitreasons.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add Reason</a></li>
                    <li><a href="{{ route('visitreasons.index') }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;See All</a></li>
                </ul>
            </li>
            <li class="submenu {{ Request::is('designations') ? 'active' : Request::is('designations/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i> <span>Designation</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('designations.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add Designation</a></li>
                    <li><a href="{{ route('designations.index') }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;See All</a></li>
                </ul>
            </li>
            <li class="submenu {{ Request::is('hosts') ? 'active' : Request::is('hosts/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span>Hosts</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('hosts.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add Host</a></li>
                    <li><a href="{{ route('hosts.index') }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;See All</a></li>
                </ul>
            </li>
            <li class="{{ Request::is('visitors') ? 'active' : '' }}"><a href="{{ route('visitors.index') }}"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span>Visitors</span></a></li>
            <li class="{{ Request::is('managevisits') ? 'active' : Request::is('managevisits/*') ? 'active' : '' }}"><a href="{{ route('managevisits.index') }}"><i class="fa fa-server" aria-hidden="true"></i> <span>Visit Requests</span></a></li>
            <li class="submenu {{ Request::is('visitreports') ? 'active' : Request::is('appointmentreports') ? 'active' : '' }}"><a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> <span>Reports</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('visitReports.index') }}"><i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Visit</a></li>
                    <li><a href="{{ route('appointmentReports.index') }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;Appointment</a></li>
                </ul>
            </li>
            <li class="submenu {{ Request::is('immediatevisits') ? 'active' : Request::is('immediatevisits/*') ? 'active' : Request::is('immediateappointments') ? 'active' : Request::is('immediateappointments/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-superpowers" aria-hidden="true"></i> <span>Immediate</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('immediatevisits.index') }}"><i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Visit</a></li>
                    <li><a href="{{ route('immediateappointments.index') }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;Appointment</a></li>
                </ul>
            </li>
            
            @elseif(Auth::user()->role=='visitor')
            <li class="submenu {{ Request::is('visits') ? 'active' : Request::is('visits/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-shield" aria-hidden="true"></i> <span>Visit Requests</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('visits.create') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;&nbsp;Request Now</a></li>
                    <li><a href="{{ route('visits.approved') }}"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Approved Requests</a></li>
                    <li><a href="{{ route('visits.index') }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;All Requests</a></li>
                </ul>
            </li>
            <li class="submenu {{ Request::is('appointments') ? 'active' : Request::is('appointments/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-shield" aria-hidden="true"></i> <span>Appointment Requests</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('appointments.create') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;&nbsp;Request Now</a></li>
                    <li><a href="{{ route('appointments.approved') }}"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Approved Requests</a></li>
                    <li><a href="{{ route('appointments.index') }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;All Requests</a></li>
                </ul>
            </li>

            @elseif(Auth::user()->role=='host')
            <li class="{{ Request::is('manageappointments') ? 'active' : Request::is('manageappointments/*') ? 'active' : '' }}"><a href="{{ route('manageappointments.index') }}"><i class="fa fa-server" aria-hidden="true"></i> <span>Appointment Requests</span></a></li>
            <li class="{{ Request::is('immediateappointments/*') ? 'active' : '' }}"><a href="{{ route('immediateappointments.show', Auth::user()->id) }}"><i class="fa fa-superpowers" aria-hidden="true"></i> <span>Immediate Appointments</span></a></li>

            @elseif(Auth::user()->role=='receptionist')
            <li class="{{ Request::is('checkvisits') ? 'active' : '' }}"><a href="{{ route('checkVisits.index') }}"><i class="fa fa-server" aria-hidden="true"></i> <span>Check Visits</span></a></li>
            <li class="{{ Request::is('checkappointments') ? 'active' : '' }}"><a href="{{ route('checkAppointments.index') }}"><i class="fa fa-server" aria-hidden="true"></i> <span>Check Appointments</span></a></li>
            <li class="submenu {{ Request::is('visitreports') ? 'active' : Request::is('visitreports/*') ? 'active' : Request::is('appointmentreports') ? 'active' : Request::is('appointmentreports/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> <span>Reports</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('visitReports.show', Auth::user()->id) }}"><i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Visit</a></li>
                    <li><a href="{{ route('appointmentReports.show', Auth::user()->id) }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;Appointment</a></li>
                </ul>
            </li>

            <li class="submenu {{ Request::is('immediatevisits') ? 'active' : Request::is('immediatevisits/*') ? 'active' : Request::is('immediateappointments') ? 'active' : Request::is('immediateappointments/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-superpowers" aria-hidden="true"></i> <span>Immediate</span> <span class="label label-important"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                <ul>
                    <li><a href="{{ route('immediatevisits.index') }}"><i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Visit</a></li>
                    <li><a href="{{ route('immediateappointments.index') }}"><i class="fa fa-meetup" aria-hidden="true"></i>&nbsp;&nbsp;Appointment</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </div>