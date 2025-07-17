<div class="sidebar">
    <div class="shrink-0 flex items-center">
            <x-application-logo class="block h-9 w-auto" />
    </div>
    @if(Auth::user()->hasPermission('claim'))
    <div style="font-weight:bolder; color:black">Claim Management</div>
    <a class="sidebar-links {{ Route::currentRouteName() == 'claim.index' ? 'active' : '' }}" href="{{route('claim.index')}}">Claims</a>
    <a class="sidebar-links {{ Route::currentRouteName() == 'claim.closed.claim' ? 'active' : '' }}" href="{{route('claim.closed.claim')}}">Closed Claims</a>
    @endif
    @if(Auth::user()->hasPermission('QA'))
    <div style="font-weight:bolder; color:black">QA Management</div>
    <a class="sidebar-links {{ Route::currentRouteName() == 'qa.claims' ? 'active' : '' }}" href="{{route('qa.claims')}}">Claims</a>
    @endif
    @if(Auth::user()->hasPermission('Distribution'))
    <div style="font-weight:bolder; color:black">Distribution Management</div>
    <a class="sidebar-links {{ Route::currentRouteName() == 'distribution.claims' ? 'active' : '' }}" href="{{route('distribution.claims')}}">Claims</a>
    <a class="sidebar-links {{ Route::currentRouteName() == 'distribution.repairs' ? 'active' : '' }}" href="{{route('distribution.repairs')}}">Repairs</a>
   @endif
    @if(Auth::user()->hasPermission('reports'))

    <div style="font-weight:bolder; color:black">Reports Management</div>
    <a class="sidebar-links {{ Route::currentRouteName() == 'report.custom-report.form' ? 'active' : '' }}" href="{{route('report.custom-report.form')}}">Customized Report</a>
    @endif
	@if(Auth::user()->hasPermission('roles-permissions-shops'))

    <div style="font-weight:bolder; color:black">Roles & Premissions</div>       
        <a class="sidebar-links {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}" href="{{route('roles.index')}}">Roles</a>
        <a class="sidebar-links {{ Route::currentRouteName() == 'permission.index' ? 'active' : '' }}" href="{{route('permission.index')}}">Permission</a>
@endif
	@if(Auth::user()->hasPermission('roles-permissions-shops') || Auth::user()->hasPermission('users'))
    <div style="font-weight:bolder; color:black">Settings</div>
	@endif
 @if(Auth::user()->hasPermission('users'))
        <a class="sidebar-links {{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}" href="{{route('user.index')}}">Users</a>
@endif
	@if(Auth::user()->hasPermission('roles-permissions-shops'))
		<a class="sidebar-links {{ Route::currentRouteName() == 'shop.index' ? 'active' : '' }}" href="{{route('shop.index')}}">Shops</a>
	@endif

</div>