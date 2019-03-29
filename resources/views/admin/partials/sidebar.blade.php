<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu"
            data-keep-expanded="false"
            data-auto-scroll="true"
            data-slide-speed="200">
            
            
            
           <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower('configurations')) class="active" @endif>
                <a href="{{ route('admin.configurations.manage') }}">
                   <i class="fa fa-sign-out fa-fw"></i>
                   <span class="title">{{ trans('Manage Configurations') }}</span>
               </a>
           </li>
            
            
            <li>
                <a href="{{ url('logout') }}" >
                    <i class="fa fa-sign-out fa-fw"></i>
                    <span class="title">{{ trans('admin/admin.partials-sidebar-logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
