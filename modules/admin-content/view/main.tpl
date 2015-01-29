<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{$DOMAIN}admin">{_("Web Administration")}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="{$DOMAIN}admin-editsiteconfig"><i class="fa fa-gear fa-fw"></i> {_("Site settings")}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{$DOMAIN}admin?logout"><i class="fa fa-sign-out fa-fw"></i> {_("Logout")}</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{$DOMAIN}admin"><i class="fa fa-dashboard fa-fw"></i> {_("Dashboard")}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{_("Content")}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button class="btn btn-default" onclick="location.href='{$DOMAIN}admin-editsettings?page=new-page';" type="button">{_("Add page")}</button>
                            <button class="btn btn-default" onclick="location.href='{$DOMAIN}admin?ra=true';" type="button">{_("Rebuild all pages")}</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="30%">{_("Page name")}</th>
                                            <th width="60%">{_("Page title")}</th>
                                            <th width="10%">{_("Actions")}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {foreach $pages as $page}
                                        {if substr($page->getName(), 0, 5) != "admin"}
                                        <tr class="odd gradeX">
                                            <td><a href="{$DOMAIN}{if $page->getName()!='index'}{$page->getName()}{/if}" target="_blank">{$page->getName()}</a></td>
                                            <td>{$page->getTitle()}</td>
                                            <td><a href="{$DOMAIN}admin-editpage?page={$page->getName()}" title="{_("Edit page")}"><span class="glyphicon glyphicon-edit"> </span></a>
                                <a href="{$DOMAIN}admin-editsettings?page={$page->getName()}"><span class="glyphicon glyphicon-cog" title="{_("Page settings")}"> </span></a>
                                <a href="?dpage={$page->getName()}"><span class="glyphicon glyphicon-remove" title="{_("Delete page")}"> </span></a>
                                <a href="?ra={$page->getName()}"><span class="glyphicon glyphicon-repeat" title="{_("Rebuild page")}"> </span></a></td>
                                        </tr>
                                        {/if}
                                    {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>