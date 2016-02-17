<script type="text/javascript">
    function encrypt() {
        var decpass = $("#decpass");
        var encpass = $("#encpass");
        $.post("admin-editsiteconfig", {
            pass: decpass.val()
        }).done(function(data) {
            encpass.val(data);
        });
    }
</script>
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
                    <h1 class="page-header">{_("Site settings")}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">{_("Form")}</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group">
                                    <label>{_("Project name")}</label>
                                    <input class="form-control" name="PROJECT_NAME" type="text" value="{$page['PROJECT_NAME']}" />
                                    <p class="help-block">{_("Name for URL")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Admin mail")}</label>
                                    <input class="form-control" name="MAILADM" type="text" value="{$page['MAILADM']}" />
                                    <p class="help-block">{_("Page title")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Domain")}</label>
                                    <input class="form-control" name="DOMAIN" type="text" value="{$page['DOMAIN']}" />
                                    <p class="help-block">{_("Page schema")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Root folder")}</label>
                                    <input class="form-control" name="ROOT" type="text" value="{$page['ROOT']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("DBHost")}</label>
                                    <input class="form-control" name="DBHOST" type="text" value="{$page['DBHOST']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("DBType")}</label>
                                    <input class="form-control" name="DBTYPE" type="text" value="{$page['DBTYPE']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("DBUser")}</label>
                                    <input class="form-control" name="DBUSER" type="text" value="{$page['DBUSER']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("DBPass")}</label>
                                    <input class="form-control" name="DBPASS" type="text" value="{$page['DBPASS']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("DBName")}</label>
                                    <input class="form-control" name="DBDATA" type="text" value="{$page['DBDATA']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Admin pass (sha1)")}</label>
                                    <input class="form-control" id="encpass" name="ADMINPASS" type="text" value="{$page['ADMINPASS']}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("SHA1 password converter")}</label>
                                    <input type="text" class="form-control" name="decpass" id="decpass" />
                                    <input type="button" onclick="encrypt();" value="{_("Crypt pass")}" />
                                </div>
                                <div class="form-group">
                                    <label>{_("Language")}</label>
                                    <select class="form-control" name="LANGUAGE">
                                        {foreach from=Utils::getSupportedLanguages() item=langs}
                                            <option value="{$langs}" {if $page['LANGUAGE'] == $langs}selected="selected" {/if}>{$langs}</option>
                                        {/foreach}
                                    </select>
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="submit" type="submit" value="{_("Save")}" />
                                </div>
                            </form>
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