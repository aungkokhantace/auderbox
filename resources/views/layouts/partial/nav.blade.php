<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar nav -->
        <ul class="nav">
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
            <li class="nav-header">AcePlus Reports</li>
            <li nav-id='report'  class="has-sub" >
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-calendar"></i>
                    <span>Reports</span>
                </a>

                <ul class="sub-menu">
                    <li nav-id="report-sale-summary"><a href="/backend/">Sale Summary Report</a></li>
                </ul>
            </li>


            <li class="nav-header">AcePlus Backend</li>

            <li nav-id="menu-manage" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                </a>

                <ul class="sub-menu">
                    <li nav-id="menu-entry"><a href="/menu/create">Entry</a></li>
                    <li nav-id="menu-list"><a href="/menu">List</a></li>
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cogs"></i>
                    <span>Site Setup</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Role</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/role/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/role">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Permission</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/permission/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/permission">List</a></li>

                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Staff</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/user/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/user">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="">
                        <a href="/backend/config">
                            <span>Site Config</span>
                        </a>
                    </li>

                    <li nav-id="">
                        <a href="/backend/api_formats">
                            <span>API Formats</span>
                        </a>
                    </li>
                </ul>
            </li>



        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>    <!-- end #sidebar -->

<script type="text/javascript">
    $(document).ready(function() {
        //make sidebar active current tab when a page is selected
        var path = window.location.pathname;
        var submenu = '.sub-menu li';
        var hassub = '.has-sub';

        $(hassub).removeClass('active');
        $(submenu).removeClass('active');

        $(".sub-menu li a").each(function () {
            var href = $(this).attr('href');
            var child_href = href+'/';
            //check for child hrefs also (eg. room and room/create)
            if (path === href || path.includes(child_href)) {
            // if (path.includes(href)) {
                $(this).closest('li').addClass('active');
                $(this).closest('.has-sub').addClass('active');
                $(this).parents(".has-sub:eq(1)").toggleClass("active");
            }
        });
    });
</script>
