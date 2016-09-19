<div class="navbar">
    <div class="navbar-inner">
            <ul class="nav pull-right">
                
                <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> {{$admin['name']}}
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="{{ $url_prefix }}/admin/{{ $admin['id'] }}/edit"><i class="icon-edit"></i> 个人信息</a></li>
                        <li class="divider"></li>
                        <li class="divider visible-phone"></li>
                        <li><a tabindex="-1" href="/auth/logout"><i class="icon-share"></i> 退出</a></li>
                    </ul>
                </li>
                
            </ul>
            <a class="brand" href="{{ $url_prefix }}/home"><span class="first"></span> <span class="second">一块购后台管理系统</span></a>
    </div>
</div>