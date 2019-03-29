<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-header-inner">
           <div class="navbar-header">
               <a href="#" class="navbar-brand" style="text-decoration: none;">
                    {{ trans('admin/admin.partials-topbar-title') }}
                    @php
                        $aUserRole = config('user_roles.user_type');
                        $user = Auth::user();
                        echo $aUserRole[$user->fk_users_role];
                    @endphp
                </a>
            </div>
            <a href="javascript:;"
               class="menu-toggler responsive-toggler"
               data-toggle="collapse"
               data-target=".navbar-collapse">
            </a>

            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                </ul>
            </div>
        </div>
    </div>
</div>