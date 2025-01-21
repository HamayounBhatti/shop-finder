<div class="sidebar">
    <div class="shrink-0 flex items-center">
            <x-application-logo class="block h-9 w-auto" />
    </div>
    @if(Auth::user()->hasPermission('claim'))
    <div style="font-weight:bolder; color:black">Claim Management</div>
    <a class="sidebar-links" href="{{route('claim.index')}}">Claims</a>
    <a class="sidebar-links" href="{{route('claim.closed.claim')}}">Closed Claims</a>
    @endif
    @if(Auth::user()->hasPermission('QA'))
    <div style="font-weight:bolder; color:black">QA Management</div>
    <a class="sidebar-links" href="{{route('qa.claims')}}">Claims</a>
    @endif
    @if(Auth::user()->hasPermission('Distribution'))
    <div style="font-weight:bolder; color:black">Distribution Management</div>
    <a class="sidebar-links" href="{{route('distribution.claims')}}">Claims</a>
    <a class="sidebar-links" href="{{route('distribution.repairs')}}">Repairs</a>
    @endif
    @if(Auth::user()->hasPermission('hms-settings'))
    <div style="font-weight:bolder; color:black">User Management</div>
        <a class="sidebar-links" href="{{route('user.index')}}">Users</a>
        <a class="sidebar-links" href="{{route('shop.index')}}">Shops</a>
    <div style="font-weight:bolder; color:black">Roles & Premissions</div>       
        <a class="sidebar-links" href="{{route('roles.index')}}">Roles</a>
        <a class="sidebar-links" href="{{route('permission.index')}}">Permission</a>
    @endif
</div>