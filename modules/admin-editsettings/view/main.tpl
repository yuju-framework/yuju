<script type="text/javascript">
    {literal}
        function setJsCss() {
            var ulCss = $("#sortable2-cssfiles li");
            var ulJs = $("#sortable2-jsfiles li");
            var textcss = "[";
            ulCss.each(function(i)
            {
                var Re = new RegExp("^(https?)");
                
                if (Re.test($(this).text())) {
                    textcss += '"' + $(this).text() + '",';
                } else {
                    textcss += '"{$DOMAIN}css/' + $(this).text() + '",';
                }
            });
            textcss = textcss.slice(0, -1) + "]";

            var textjs = "[";
            ulJs.each(function(i)
            {
                var Re = new RegExp("^(https?)");
                if (Re.test($(this).text())) {
                    textjs += '"' + $(this).text() + '",';
                } else {
                    textjs += '"{$DOMAIN}js/' + $(this).text() + '",';
                }
            });
            textjs = textjs.slice(0, -1) + "]";

            $("#text-cssfiles").val(textcss);
            $("#text-jsfiles").val(textjs);

        }
        
        function addModule() {
            $.get("rpc.php",
                {
                    call: "{\"module\":\"modules\",\"params\":{\"function\":\"public\"}}"
                },function(data) {
                    if (data.estate == 1) {
                        var datamodules = '<div class="row">';
                        for (var module in data.response) {
                            datamodules+="<div class=\"col-md-4\">";
                            datamodules+='<button class="btn btn-link" onclick="setTemporalModule(\''+data.response[module]+'\');" type="button">';
                            datamodules+=data.response[module];
                            datamodules+="</button></div>";
                        }
                        datamodules+="</div>";
                        $('#listmodulesbody').html(datamodules);
                        $('#listmodules').modal('show');
                    }
                }
            );
        }
        
        function updateSource() {
        	var modulos = "{ ";
            $(".addmodules").each(function(index) {
                modulos+="\"MOD"+index+"\":[";
                    $("#mod-"+index+" li").each(function(index) {
                        modulos+= $(this).attr('data-content')+",";
                    });
                modulos+="],";
            });
            modulos+=" }";
            $('#modules').val(JSON.stringify(eval("(" +modulos+")"),null, 4));
        }
        
        function setTemporalModule(name) {
            var element = $('<li class="ui-state-default" data-trigger="hover" data-toggle="popover" data-placement="bottom" title="Module properties" data-content="">'+name+' <i class="fa fa-times btn-danger" onclick="$(\'li[data-toggle*=\\\'popover\\\']\').popover(\'hide\');$(this).parent().remove();" style="float:right;cursor:pointer;"></i></li>');
            element.attr('data-content','{"'+name+'":{"_empty_": ""}}');
            $('#mod').append(element);
            $('li[data-toggle*=\'popover\']').popover();
            $('#listmodules').modal('hide');
        }
        
        function updateSchema()
        {
            
        }
    {/literal}
</script>
<div class="modal fade" id="listmodules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h4>{_("Modules list")}</h4></div>
      <div class="modal-body" id="listmodulesbody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="formmodule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h4>{_("Modules list")}</h4></div>
      <div class="modal-body" id="formmodulebody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" >Add module</button>
      </div>
    </div>
  </div>
</div>

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
                    <h1 class="page-header">{_("Page settings")}</h1>
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
                                    <label>{_("Name")}</label>
                                    <input class="form-control" name="namet" type="text" value="{$page->getName()}" />
                                    <p class="help-block">{_("Name for URL")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Title")}</label>
                                    <input class="form-control" name="title" type="text" value="{$page->getTitle()}" />
                                    <p class="help-block">{_("Page title")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Schema")}</label>
                                    <select name="schema" id="schema" class="form-control">
                                        <option value=""></option>
                                        {foreach from=$schemas item=schema}
                                            <option value="{$schema->getNameNoExtension()}" nummod="{Yuju_View::getNumModulesBySchema($schema->getNameNoExtension())}" {if $schema->getNameNoExtension() == $page->getSchema()}selected="selected"{/if} onchange="updateSchema();">{$schema->getNameNoExtension()}</option>
                                        {/foreach}
                                    </select><button class="btn btn-default" type="button">{_("Change schema")}</button>
                                    <p class="help-block">{_("Page schema")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Type")}</label>
                                    <input class="form-control" name="type" type="text" value="{$page->getType()}" />
                                    <p class="help-block">{_("Page type")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Files")}</label>
                                    <style>
                                        .sortable-cssfiles, .sortable-jsfiles { list-style-type: none; margin: 0; padding: 0; width: 60%; min-height:20px; cursor: move;}                                        
                                    </style>
                                    
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="panel panel-yellow">
                                                <div class="panel-heading">{_("Style Files available")}</div>
                                                <div class="panel-body">
                                                    <ul id="sortable1-cssfiles" class="sortable-cssfiles">
                                                        {foreach from=$cssfiles item="listitem"}
                                                            {if !in_array($listitem, $loadcssfiles)}
                                                                <li class="ui-state-default">{$listitem}</li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">{_("Style Files in use")}</div>
                                                <div class="panel-body">
                                                    <ul id="sortable2-cssfiles" class="sortable-cssfiles">
                                                        {foreach from=$loadcssfiles item="listitem"}
                                                            <li class="ui-state-default">{$listitem}</li>
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                                <div class="panel-footer"><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-addcssurl" type="button">{_("Add external URL")}</button></div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="text-cssfiles" value="" id="text-cssfiles">
                                        <script type="text/javascript">
                                            $("ul.sortable-cssfiles").sortable({
                                                connectWith: ".sortable-cssfiles",
                                                update: function(event, ui) {
                                                    var textOutput = "[";
                                                    $("#sortable2-cssfiles li").each(function(i) {
                                                        //textOutput += '"{$DOMAIN}css/' + $(this).text() + '",';
                                                        textOutput += '"$DOMAIN/css' + $(this).text() + '",';
                                                    });
                                                    textOutput = textOutput.slice(0, -1) + "]";
                                                }
                                            });
                                            $("ul.sortable-cssfiles").disableSelection();
                                        </script>
                                        <div class="col-lg-3">
                                            <div class="panel panel-yellow">
                                                <div class="panel-heading">{_("JavaScript Files available")}</div>
                                                <div class="panel-body">
                                                    <ul id="sortable1-jsfiles" class="sortable-jsfiles">
                                                        {foreach from=$jsfiles item="listitem"}
                                                            {if !in_array($listitem, $loadjsfiles)}
                                                                <li class="ui-state-default">{$listitem}</li>
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">{_("JavaScript Files in use")}</div>
                                                <div class="panel-body">
                                                    <ul id="sortable2-jsfiles" class="sortable-jsfiles">
                                                        {foreach from=$loadjsfiles item="listitem"}
                                                            <li class="ui-state-default">{$listitem}</li>
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                                <div class="panel-footer"><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-addjsurl" type="button">{_("Add external URL")}</button></div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="text-jsfiles" value="" id="text-jsfiles">
                                        <script type="text/javascript">
                                            $("ul.sortable-jsfiles").sortable({
                                                connectWith: ".sortable-jsfiles",
                                                update: function(event, ui) {
                                                    var textOutput = "[";
                                                    $("#sortable2-jsfiles li").each(function(i) {
                                                        //textOutput += '"{$DOMAIN}js/' + $(this).text() + '",';
                                                        textOutput += '"$DOMAIN/js' + $(this).text() + '",';
                                                    });
                                                    textOutput = textOutput.slice(0, -1) + "]";
                                                }
                                            });
                                            $("ul.sortable-cssfiles").disableSelection();
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{_("Keywords")}</label>
                                    <input class="form-control" name="keywords" type="text" value="{$page->getKeyword()}" />
                                    <p class="help-block">{_("Page keywords for SEO")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Description")}</label>
                                    <input class="form-control" name="description" type="text" value="{$page->getDescription()}" />
                                    <p class="help-block">{_("Page description for SEO")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Modules")}</label>
                                    <style>
                                        .sortable-modules { list-style-type: none; margin: 0; padding: 0;min-height:20px; cursor: move;}
                                        .sortable-modules li { margin: 0 3px 3px 3px; padding: 0.4em;}
                                        .sortable-modules li:hover { margin: 0 3px 3px 3px; padding: 0.4em; background-color: lightblue; }
                                        .sortable-modules li span { position: absolute; margin-left: -1.3em; }
                                    </style>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="panel panel-yellow">
                                                <div class="panel-heading">
                                                    {_("Temp MOD")}
                                                </div>
                                                <div class="panel-body">
                                                    <ul id="mod" class="sortable-modules">
                                                    </ul>
                                                </div>
                                                <div class="panel-footer"><button class="btn btn-default btn-xs" onclick="addModule()" type="button">{_("Add module")}</button></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    MOD 0
                                                </div>
                                                <div class="panel-body">
                                                    <ul id="mod-0" class="sortable-modules addmodules">
                                                        {$num_module=0}
                                                        {foreach $page->getModules("MOD0") as $modules}
                                                            {$num_module=$num_module+1}
                                                            <li class="ui-state-default" data-toggle="popover" data-placement="bottom" title="Module properties" data-content="{$page->getModulesJson(null,$num_module)|escape}">{key($modules)} <i class="fa fa-times btn-danger" onclick="$('li[data-toggle*=\'popover\']').popover('hide');$(this).parent().remove();updateSource();" style="float:right;cursor:pointer;"></i></li>
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                                <div class="panel-footer">&nbsp;</div>
                                            </div>
                                        </div>
                                        {$num=2}
                                        {for $i=1 to Yuju_View::getNumModulesBySchema($page->getSchema())}
                                            {if $num==4}
                                                </div>
                                                <div class="row">
                                                {$num=0}
                                            {/if}
                                            {$num=$num+1}
                                            <div class="col-lg-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        MOD {$i}
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul id="mod-{$i}" class="sortable-modules addmodules">
                                                        	{$module="MOD`$i`"}
                                                            {foreach $page->getModules($module) as $modules}
                                                                {$num_module=$num_module+1}
                                                                <li class="ui-state-default" data-trigger="hover" data-toggle="popover" data-placement="bottom" title="Module properties" data-content="{$page->getModulesJson(null,$num_module)|escape}">{key($modules)} <i class="fa fa-times btn-danger" onclick="$('li[data-toggle*=\'popover\']').popover('hide');$(this).parent().remove();updateSource();" style="float:right;cursor:pointer;"></i></li>
                                                            {/foreach}
                                                        </ul>
                                                    </div>
                                                    <div class="panel-footer">&nbsp;</div>
                                                </div>
                                            </div>
                                        {/for}
                                    </div>
                                    <script>
                                        $(".sortable-modules").sortable({
                                            connectWith: ".sortable-modules",
                                            update: function( event, ui ) {
                                                updateSource();                                          
                                            }
                                        }).disableSelection();
                                        $( "li[data-toggle*='popover']" ).popover();
                                    </script>
                                    <label>{_("Source modules")}</label>
                                    <textarea class="form-control" rows="10" id="modules" name="modules" type="text">{$page->getModulesJson()}</textarea>
                                    <script type="text/javascript">
                                    {literal}$('#modules').val(JSON.stringify(eval("(" + $('#modules').val()+")"),null, 4));{/literal}
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>{_("Parent")}</label>
                                    <select name="parent" class="form-control">
                                        <option value=""></option>
                                        {foreach Yuju_View::getAll() as $pages}
                                            <option value="{$pages->getName()}" {if $pages->getName() == $page->getParent()}selected="selected"{/if}>{$pages->getName()}</option>
                                        {/foreach}
                                    </select>
                                    <p class="help-block">{_("Parent page")}</p>
                                </div>
                                <div class="form-group">
                                    <label>{_("Site Map")}</label>
                                    <div class="radio">
                                    <label><input type="radio" name="sitemap" value="1" {if $page->getSiteMap()=='1'}checked="checked"{/if} />{_("Yes")}</label>
                                    </div>
                                    <div class="radio">
                                    <label><input type="radio" name="sitemap" value="0" {if $page->getSiteMap()=='0'}checked="checked"{/if} />{_("No")}</label>
                                    </div>
                                    <p class="help-block">{_("Show page on sitemap")}</p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="submit" onclick="setJsCss();" type="submit" value="{_("Save")}" />
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
    
<div class="modal fade" id="modal-addcssurl" role="dialog" aria-labelledby="myModalLabelCSS" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">{_("New Style URL")}</div>
          <div class="modal-body">
            <div class="form-group">
                <label>{_("URL")}</label>
                <input class="form-control" name="addcssurl" id="addcssurl" type="text" value="" />
                <p class="help-block">{_("Type full URL, example: http://www.example.com/")}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="$('#addcssurl').val('');" data-dismiss="modal">{_("Close")}</button>
            <button type="button" onclick="addJSCSS('css');" class="btn btn-primary">{_("Add")}</button>
          </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-addjsurl" role="dialog" aria-labelledby="myModalLabelJs" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">{_("New JavaScript URL")}</div>
            <div class="modal-body">
                <div class="form-group">
                    <label>{_("URL")}</label>
                    <input class="form-control" name="addjsurl" id="addjsurl" type="text" value="" />
                    <p class="help-block">{_("Type full URL, example: http://www.example.com/")}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="$('#addjsurl').val('');" data-dismiss="modal">{_("Close")}</button>
                <button type="button" onclick="addJSCSS('js');" class="btn btn-primary">{_("Add")}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function addJSCSS(type) {
        if (type =='css') {
            $('#sortable2-cssfiles').append('<li class="ui-state-default ui-sortable-handle">'+$('#addcssurl').val()+'</li>');
            $('#modal-addcssurl').modal('hide');
        } else if(type =='js') {
            $('#sortable2-jsfiles').append('<li class="ui-state-default ui-sortable-handle">'+$('#addjsurl').val()+'</li>');
            $('#modal-addjsurl').modal('hide');
        }
    }
</script>