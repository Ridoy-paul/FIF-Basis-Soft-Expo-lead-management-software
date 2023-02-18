<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header bg-white-5">
        <a class="font-w600 text-dual" href="{{route('/')}}">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">FIF, Basis Soft Expo.<span class="font-w400"></span>
            </span>
        </a>
        
        <div>
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <div class="content-side">
        <ul class="nav-main">
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('/')}}">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">Dashboard</span></span>
                </a>
            </li>
            @if($user->type == 'admin') 
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('admin.crm')}}">
                    <i class="nav-main-link-icon fas fa-user-friends"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">CRM</span></span>
                </a>
            </li>
            {{--
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('institute.index')}}">
                    <i class="nav-main-link-icon fas fa-plane"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">Institutes</span></span>
                </a>
            </li>
            
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('subject.index')}}">
                    <i class="nav-main-link-icon fas fa-money-check"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">Subjects</span></span>
                </a>
            </li>
            --}}
            @elseif ($user->type == 'crm')

            @endif
            
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('visitor.create')}}">
                    <i class="nav-main-link-icon fas fa-id-card-alt"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">Register Visitor</span></span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{route('visitor.index')}}">
                    <i class="nav-main-link-icon fa fa-file"></i>
                    <span class="nav-main-link-name"><span class="rounded p-1 ">All Visitors</span></span>
                </a>
            </li>
            </ul>
        </div>
    </div>
</nav>

