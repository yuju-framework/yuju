<?php
/**
 * YujuView File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

namespace YujuFramework;

use YujuFramework\DataBase\DB;

 /**
  * YujuView Class
  *
  * @category Core
  * @package  YujuFramework
  * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
  * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
  * @link     https://github.com/yuju-framework/yuju
  * @since    version 1.0
  */
class YujuView
{
    protected $name;
    protected $title;
    protected $schema;
    protected $keyword;
    protected $description;
    protected $modules;
    protected $type;
    protected $html;
    protected $jsfiles;
    protected $cssfiles;
    protected $get = array();
    private $template;
    protected $modulesjson;
    protected $parent;
    protected $sitemap;
    protected $meta;
    protected $regex;

    /**
     * Getter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function getHTML()
    {
        return json_encode($this->html);
    }

    public function setHTML($html)
    {
        $this->html = json_decode($html);
    }

    public function getJsfiles()
    {
        return json_encode($this->jsfiles);
    }

    public function setJsfiles($jsfiles)
    {
        $this->jsfiles = json_decode($jsfiles);
    }

    public function getCssfiles()
    {
        return json_encode($this->cssfiles);
    }

    public function setCssfiles($cssfiles)
    {
        $this->cssfiles = json_decode($cssfiles);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setModules($modules)
    {
        $this->modules = json_decode($modules, true);
    }

    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Get modules to JSON
     *
     * @param string $var    modue name
     * @param string $nummod num module
     *
     * @return string|multitype:
     */
    public function getModulesJson($var = null, $nummod = '0')
    {
        if ($var == null && $nummod =='0') {
            return $this->modulesjson;
        } elseif (is_numeric($var)) {
            if (isset($this->modules[$var])) {
                return json_encode($this->modules[$var]);
            } else {
                return array();
            }
        }
        if ($nummod !='0') {
            $c = 1;
            foreach ($this->modules as $modules) {
                foreach ($modules as $module) {
                    if ($c == $nummod) {
                        return json_encode($module);
                    }
                    $c++;
                }
            }
        }
    }

    /**
     * Load GET values
     *
     * @return void
     */
    public function loadGET()
    {
        foreach ($_GET as $name => $value) {
            if ($name !='p') {
                $this->get[$name] = $value;
            }
        }
    }

    /**
     * Setter GET value
     *
     * @param string $name  name
     * @param mixed  $value value
     *
     * @return void
     */
    public function setGET($name, $value)
    {
        $this->get[$name] = $value;
    }

    /**
     * Generate URL GET
     *
     * @return string
     */
    public function generateGET()
    {
        $url = '';
        if (count($this->get) > 0) {
            $url = '?';
            foreach ($this->get as $name => $value) {
                $url.=$name . '=' . $value . '&';
            }
            $url = substr($url, 0, strlen($url) - 1);
        }
        return $url;
    }

    /**
     * Getter modules
     *
     * @param integer $var    var
     * @param integer $nummod num module
     *
     * @return array
     */
    public function getModules($var = null, $nummod = '0')
    {
        if ($var != null) {
            if (substr($var, 0, 3)=='MOD') {
                if (isset($this->modules[$var])) {
                    return $this->modules[$var];
                } else {
                    return array();
                }
            } else {
                $arr = array();
                for ($i = 0; $i < 100; $i++) {
                    if (isset($this->modules[$nummod][$i][$var])) {
                        $arr[] = $this->modules[$nummod][$i][$var];
                    }
                }
                return $arr;
            }
        } else {
            return $this->modules;
        }
    }

    /**
     * Setter module
     *
     * @param string  $namemodule module name
     * @param string  $module     module
     * @param integer $nummod     module num
     * @param integer $num        num
     *
     * @return void
     */
    public function setModule($namemodule, $module, $nummod, $num = null)
    {
        if ($num == null) {
            $this->modules[$nummod][] = $module;
        } elseif (is_numeric($num)) {
            $newarray = array();
            $c = 1;
            foreach ($this->modules as $numkey => $value) {
                $newarray[$numkey] = array();
                foreach ($value as $name => $val) {
                    if ($c == $num) {
                        $newarray[$numkey][][$namemodule] = $module;
                    } else {

                        $newarray[$numkey][$name] = $val;

                    }

                    $c++;
                }
            }
            $this->modules = $newarray;
        }
    }

    /**
     * Getter parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Setter parent
     *
     * @param string $parent name page parent
     *
     * @return void
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Getter sitemap
     *
     * @return integer
     */
    public function getSiteMap()
    {
        return $this->sitemap;
    }

    /**
     * Setter sitemap
     *
     * @param integer $var sitemap
     *
     * @return boolean
     */
    public function setSiteMap($var)
    {
        if ($var=='0' || $var=='1') {
            $this->sitemap = $var;
            return true;
        }
        return false;
    }

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        if (defined('API')) {
            include_once API . 'lib/Smarty/Smarty.class.php';
        } else {
            include_once ROOT . 'lib/Smarty/Smarty.class.php';
        }
        $this->template = new \Smarty();
        $this->cssfile = array();
        $this->jsfile = array();
        $this->html = array();
        $this->template->template_dir = ROOT . 'templates/';
        $this->template->compile_dir = ROOT . 'compiled/';
        $this->template->cache_dir = ROOT . 'cache/';
        $this->template->assign('DOMAIN', DOMAIN);
        $this->template->assign('ROOT', ROOT);
        $this->template->setCaching(false);
        global $activeuser;
        $this->template->assignByRef('activeuser', $activeuser, true);
        $this->template->assignByRef('view', $this, true);
        $this->template->assignByRef('__meta', $this->meta, true);
    }

    /**
     * Assign var
     *
     * @param string  $tpl_var var name
     * @param mixed   $var     value
     * @param boolean $nocache no cache
     *
     * @return void
     */
    public function assign($tpl_var, $var, $nocache = false)
    {
        $this->template->assign($tpl_var, $var, $nocache);
    }

    /**
     * Assign var
     *
     * @param string  $tpl_var var name
     * @param mixed   $var     value
     * @param boolean $nocache no cache
     *
     * @return void
     */
    public function assignByRef($tpl_var, $var, $nocache = false)
    {
        $this->template->assignByRef($tpl_var, $var, $nocache);
    }

    /**
     * Fetch page
     *
     * @param string $template template
     *
     * @return string
     */
    public function fetch($template)
    {
        return $this->template->fetch($template);
    }

    /**
     * Display page
     *
     * @param string $template   template
     * @param mixed  $cache_id   cache id
     * @param mixed  $compile_id compile id
     * @param object $parent     parent
     *
     * @return void
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        if (YujuView::exist(str_replace('&', '/', substr($template, 0, strlen($template) - 4)))) {
            $this->load(str_replace('&', '/', substr($template, 0, strlen($template) - 4)));
            return $this->template->display($template, $cache_id, $compile_id, $parent);
        }
    }

    /**
     * Get page
     *
     * @param string $n page name
     *
     * @return mixed
     */
    public function getPage($n)
    {
        if ($n == '') {
            $n = 'index';
        }
        $template = YujuView::exist($n);
        if ($template!==false) {
            if ($n != $template) {
                $this->regex = substr($n, strlen($template));
            }
            return str_replace('/', '&', $template);
        } else {
            $this->NotFound();
            return false;
        }
    }

    /**
     * Show Not found page
     *
     * @return void
     */
    public function notFound()
    {
        header('HTTP/1.1 404 Not Found');
        $this->template->display(ROOT . 'schema/not-found.tpl');
    }

    /**
     * Determine if exist a page
     *
     * @param string $n page
     *
     * @return boolean|string
     */
    public static function exist($n)
    {
        $explode = explode('/', $n);
        
        $result = DB::Query(
            'SELECT name from page WHERE name=\'' . DB::Parse($n) . '\'
            OR (regex=1 AND name=\''.DB::parse($explode[0]).'\')'
        );
        if ($result->numRows() > 0) {
            $return  = $result->fetchObject();
            return $return->name;
        } else {
            return false;
        }
    }

    /**
     * Load page
     *
     * @param string $name page name
     *
     * @return void
     */
    public function load($name)
    {
        $result = DB::Query('SELECT * from page WHERE name=\'' . DB::Parse($name) . '\'');
        if ($result->numRows() > 0) {
            $obj = $result->fetchObject();
            $this->name = $obj->name;
            $this->title = $obj->title;
            $this->schema = $obj->schema;
            $this->type = $obj->type;
            $this->html = json_decode($obj->html, true);
            $this->keyword = $obj->keyword;
            $this->description = $obj->description;
            $this->modules = json_decode($obj->modules, true);
            $this->cssfiles = json_decode($obj->cssfiles, true);
            $this->jsfiles = json_decode($obj->jsfiles, true);
            $this->modulesjson = $obj->modules;
            $this->parent = $obj->parent;
            $this->sitemap = $obj->sitemap;
        }
    }

    /**
     * Save page definition
     *
     * @return void
     */
    public function save()
    {
        $sql = 'UPDATE page SET ';
        $sql.='title=\'' . DB::Parse($this->title) . '\',';
        $sql.='`schema`=\'' . DB::Parse($this->schema) . '\',';
        $sql.='type=\'' . DB::Parse($this->type) . '\',';
        $sql.='cssfiles=\'' . DB::Parse(json_encode($this->cssfiles)) . '\',';
        $sql.='jsfiles=\'' . DB::Parse(json_encode($this->jsfiles)) . '\',';
        $sql.='keyword=\'' . DB::Parse($this->keyword) . '\',';
        $sql.='description=\'' . DB::Parse($this->description) . '\',';
        $sql.='modules=\'' . DB::Parse(json_encode($this->modules)) . '\',';
        $sql.='parent=\'' . DB::Parse($this->parent) . '\',';
        $sql.='sitemap=\'' . DB::Parse($this->sitemap) . '\' ';
        $sql.=' WHERE name=\'' . DB::Parse($this->name) . '\'';
        DB::query($sql);
    }

    /**
     * Insert page
     *
     * @return void
     */
    public function insert()
    {
        $sql = 'insert into page (`title`,`name`, `schema`, `type`, `cssfiles`, `jsfiles`, `keyword`, `description`, ';
        $sql.= '`modules`, `parent`, `sitemap`) VALUES ';
        $sql.='(\'' . DB::Parse($this->title) . '\',';
        $sql.='\'' . DB::Parse($this->name) . '\',';
        $sql.='\'' . DB::Parse($this->schema) . '\',';
        $sql.='\'' . DB::Parse($this->type) . '\',';
        $sql.='\'' . DB::Parse(json_encode($this->cssfiles)) . '\',';
        $sql.='\'' . DB::Parse(json_encode($this->jsfiles)) . '\',';
        $sql.='\'' . DB::Parse($this->keyword) . '\',';
        $sql.='\'' . DB::Parse($this->description) . '\',';
        $sql.='\'' . DB::Parse(json_encode($this->modules)) . '\',';
        $sql.='\'' . DB::Parse($this->parent) . '\',';
        $sql.='\'' . DB::Parse($this->sitemap) . '\')';
        DB::query($sql);
        $this->makeTemplate($this->name);
    }

    /**
     * Get all pages
     *
     * @return array
     */
    public static function getAll()
    {
        $all = array();
        $result = DB::query('SELECT * from page ORDER BY name ASC');
        while ($obj = $result->fetchObject()) {
            $w = new YujuView();
            $w->load($obj->name);
            $all[] = $w;
        }
        return $all;
    }

    /**
     * Set OG meta
     *
     * @param string $name  name
     * @param value  $value value
     *
     * @return void
     */
    public function setOG($name, $value)
    {
        $this->meta .='<meta property="og:'.$name.'" content="'.$value.'" />';
    }

    /**
     * Build page
     *
     * @param string $type build type
     *
     * @return string
     */
    public function build($type = 'view')
    {
        // Load modules PHP
        $hload = '';
        $mods['__MOD0'] = '';

        $idmod = 0;
        // Load modules
        foreach ($this->modules as $nummod => $mod) {
            // Name of module
            $namemod = '__MOD' . substr($nummod, 3);
            if (!isset($$namemod)) {
                // HACK: If not exist, create
                $$namemod = '';
            }
            // Include modules PHP
            foreach ($mod as $vars) {
                $tmp = '';
                $htmp = '';
                $idmod++;

                foreach ($vars as $names => $var) {
                    if ($type == 'edit') {
                        if ($this->existAdminModuleView($names)) {

                            $tmp = '{include file="' . $this->existAdminModuleView($names) . '"';
                            foreach ($var as $key => $value) {
                                if (is_array($value)) {
                                    $json = json_encode($value);
                                    $value = str_replace("{", "{ ", $json);
                                    $value = str_replace("}", " }", $value);
                                    $tmp.=' ' . $key . '="' . str_replace("\"", "\\\"", $value) . '"';

                                } else {
                                    $tmp.=' ' . $key . '="' . str_replace("\"", "\\\"", $value) . '"';

                                }
                            }
                            $tmp.=' idmod="' . $idmod . '"';
                            $tmp.=' nummod="' . $nummod . '"';
                        } elseif ($this->existModuleView($names)) {
                            $tmp = '{include file="' . $this->existModuleView($names) . '"';
                            if (is_array($var)) {
                                foreach ($var as $key => $value) {
                                    if (is_array($value)) {
                                        $json = json_encode($value);
                                        $value = str_replace("{", "{ ", $json);
                                        $value = str_replace("}", " }", $value);
                                        $tmp.=' ' . $key . '="' . str_replace("\"", "\\\"", $value) . '"';
                                    } else {
                                        $tmp.=' ' . $key . '="' . str_replace("\"", "\\\"", $value) . '"';
                                    }
                                }
                            }
                        }
                        $tmp.='}';
                    } else {
                        if ($this->existModuleView($names)) {
                            if (is_array($var)) {
                                $tmp = '{include file="' . $this->existModuleView($names) . '"';
                                foreach ($var as $namevar => $valuevar) {
                                    if ($namevar != '') {
                                        if ($namevar == 'nocache') {
                                            $tmp.=' nocache';
                                        } elseif (is_array($valuevar)) {
                                            $json = json_encode($valuevar);
                                            $value = str_replace("{", "{ ", $json);
                                            $value = str_replace("}", " }", $value);
                                            $tmp.=' ' . $namevar . '="' . str_replace("\"", "\\\"", $value) . '"';
                                        } else {
                                            $tmp.=' ' . $namevar . '="' . str_replace("\"", "\\\"", $valuevar) . '"';
                                        }
                                    }
                                }
                                $tmp.='}';
                            }
                        }
                    }
                }
                foreach ($vars as $names => $var) {
                    if ($type == 'edit') {
                        if ($this->existAdminModuleController($names)) {
                            foreach ($var as $namevar => $valuevar) {
                                if ($namevar != '') {
                                    if ($namevar == 'nocache') {
                                        $htmp.=' nocache';
                                    } elseif (is_array($valuevar)) {
                                        $json = json_encode($valuevar);
                                        $value = str_replace("{", "{ ", $json);
                                        $value = str_replace("}", " }", $value);
                                        $htmp.=' ' . $namevar . '="' . str_replace("\"", "\\\"", $value) . '"';
                                    } else {
                                        $htmp.=' ' . $namevar . '="'.str_replace("\"", "\\\"", $valuevar) . '"';
                                    }
                                }
                            }
                            $hload.='{loadmodule modname="' . $names . '"' . $htmp . '}';
                        }
                    } else {
                        if ($this->existModuleController($names)) {
                            foreach ($var as $namevar => $valuevar) {
                                if ($namevar != '') {
                                    if ($namevar == 'nocache') {
                                        $htmp.=' nocache';
                                    } elseif (is_array($valuevar)) {
                                        $json = json_encode($valuevar);
                                        $value = str_replace("{", "{ ", $json);
                                        $value = str_replace("}", " }", $value);
                                        $htmp.=' ' . $namevar . '="' . str_replace("\"", "\\\"", $value) . '"';
                                    } else {
                                        $htmp.=' ' . $namevar . '="' .
                                                str_replace("\"", "\\\"", $valuevar) . '"';
                                    }
                                }
                            }
                            $hload.='{loadmodule modname="' . $names . '"' . $htmp . '}';
                        }
                    }
                }
                $$namemod.=$tmp;
            }
            $mods[$namemod] = $$namemod;
        }
        
        if ($this->type == 'html') {
            $header = $this->generateHeader($type);
        } else {
            $header = '';
        }
        if ($this->type == 'html' && $type != 'edit') {
            $foot = $this->generateJS('down');
            $foot .= '</body></html>';
        } else {
            $foot = '';
        }
        $fs = fopen(ROOT . 'schema/' . $this->schema . '.tpl', 'r');
        $schema = fread($fs, filesize(ROOT . 'schema/' . $this->schema . '.tpl'));
        foreach ($mods as $key => $value) {
            $schema = str_replace('{$' . $key . '}', $value, $schema);
        }
        
        return $hload . $mods['__MOD0'] . $header . $schema . $foot;
    }
    
    private function generateHeader($type)
    {
        if ($this->name == "index") {
            $domain = DOMAIN;
        } else {
            $domain = DOMAIN . $this->name;
        }
        
        if ($type == 'edit') {
            $header ='';
        } else {
            $header  = '<!DOCTYPE html>';
            $header .= $this->generateHTMLTag();
            $header .= '<head>';
            $header .= '<meta charset="'.(isset($this->html['charset'])?$this->html['charset']:'utf-8').'">';
            if (isset($this->html['X-UA-Compatible']) && $this->html['X-UA-Compatible'] != '') {
                $header .= '<meta http-equiv="X-UA-Compatible" content="'.$this->html['X-UA-Compatible'].'">';
            } elseif (!isset($this->html['X-UA-Compatible'])) {
                $header .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
            }
            if (isset($this->html['viewport']) && $this->html['viewport'] != '') {
                $header .= '<meta name="viewport" content="'.$this->html['viewport'].'">';
            } elseif (!isset($this->html['viewport'])) {
                $header .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
            }
            
            if (!isset($this->html['nocanonical']) || $this->html['nocanonical']!=1) {
                $header .= '<link rel="canonical" href="{$__canonical|default:\'' . $domain . '\'}">';
            }
            if (!isset($this->html['nofavicon']) || $this->html['nofavicon']!=1) {
                $header .= '<link href=' . DOMAIN . 'images/favicon.ico rel="shortcut icon">';
            }
            if (!isset($this->html['silence']) || $this->html['silence']!=1) {
                $header .= '<meta name="generator" content="Yuju Framework">';
            }
            $header.= $this->generateTitle();
            if (!isset($this->html['nodescription']) || $this->html['nodescription']!=1) {
                $header .= '<meta name="description" ';
                $header .= 'content="{$__description|default:\'' . $this->description . '\'}">';
            }
            if (!isset($this->html['nokeywords']) || $this->html['nokeywords']!=1) {
                $header .= '<meta name="keywords" ';
                $header .= 'content="{$__keyword|default:\'' . $this->keyword . '\'}">';
            }
            
            if (!isset($this->html['addmeta']) || $this->html['addmeta']==1) {
                $header .= '{$__meta|default:\'\'}';
            }
            
            if (isset($this->html['meta']) && count($this->html['meta'])>0) {
                foreach ($this->html['meta'] as $meta_value) {
                    $header .= '<meta name="'.key($meta_value).'" content="' .$meta_value[key($meta_value)] . '">';
                }
            }
        }
        $header .= $this->generateCSS();
        $header .= $this->generateJS();
        
        if ($type != 'edit') {
            $header.='</head>';
            $header.=$this->generateBody();
        }
        
        return $header;
    }
    
    
    private function generateTitle()
    {
        $header = '';
        $tags = '';
        $nodefault = false;
        if (!isset($this->html['title'])) {
            $header = '<title>{$__title|default:\'' . $this->title . '\'}</title>';
        } else {
            foreach ($this->html['title'][0] as $key => $value) {
                if ($key !== 'nodefault') {
                    if ($value !='') {
                        $tags .= ' '.$key.'="'.$value.'"';
                    } else {
                        $tags .= ' '.$key;
                    }
                } else {
                    $nodefault = true;
                }
            }
            if ($nodefault) {
                $header .= '<title'.$tags.'>' . $this->title . '</title>';
            } else {
                $header .= '<title'.$tags.'>{$__title|default:\'' . $this->title . '\'}</title>';
            }
        }
        
        return $header;
    }
    
    private function generateBody()
    {
        $header = '';
        $tags = '';
        if (!isset($this->html['body'])) {
            $header = '<body>';
        } else {
            foreach ($this->html['body'][0] as $key => $value) {
                if ($value !='') {
                    $tags .= ' '.$key."=\"".$value."\"";
                } else {
                    $tags .= ' '.$key;
                }
            }
            $header .= '<body'.$tags.'>';
        }
        
        return $header;
    }
    
    private function generateHTMLTag()
    {
        $header = '';
        $tags = '';
        if (!isset($this->html['html'])) {
            $header = '<html>';
        } else {
            foreach ($this->html['html'][0] as $key => $value) {
                if ($value !='') {
                    $tags .= ' '.$key."=\"".$value."\"";
                } else {
                    $tags .= ' '.$key;
                }
            }
            $header .= '<html'.$tags.'>';
        }
        
        return $header;
    }
    
    private function generateCSS()
    {
        $css = '';
        if ($this->cssfiles != "" && count($this->cssfiles) > 0) {
            foreach ($this->cssfiles as $css_file) {
                $rel = "stylesheet";
                $tags = '';
                foreach ($css_file as $key => $value) {
                    if ($key == 'rel') {
                        $rel = $value;
                    } else {
                        if ($key !='') {
                            $tags .= ' '.$key.'="'.$value.'"';
                        } else {
                            $tags .= '.'.$key;
                        }
                    }
                }
                $css .= '<link rel="'.$rel.'"'.$tags.'>';
            }
        }
        return $css;
    }
    
    private function generateJS($location = 'up')
    {
        $js = '';
        if ($this->jsfiles != "" && count($this->jsfiles) > 0) {
            foreach ($this->jsfiles as $js_file) {
                $islocation = 'up';
                $tags = '';
                foreach ($js_file as $key => $value) {
                    if ($key == 'location') {
                        $islocation = $value;
                    } else {
                        if ($key !='') {
                            $tags .= ' '.$key.'="'.$value.'"';
                        } else {
                            $tags .= '.'.$key;
                        }
                    }
                }
                if ($islocation ==$location) {
                    $js .= '<script'.$tags.'></script>';
                }
            }
        }
        return $js;
    }
    
    /**
     * Make template page
     *
     * @param string $name page name
     *
     * @return boolean
     */
    public function makeTemplate($name)
    {
        if ($name == 'compile-all-web-pages') {
            $result = DB::query('SELECT * from page');
            while ($obj = $result->fetchObject()) {
                $w = new YujuView();
                $w->MakeTemplate($obj->name);
            }
            return true;
        }
        $result = DB::query(
            'SELECT name from page WHERE name=\'' . DB::Parse($name) . '\''
        );
        if ($result->numRows() > 0) {
            $obj = $result->fetchObject();
            $this->load($obj->name);
            $template = $this->Build();
            // TODO: first delete file if exist
            $f = @fopen(ROOT . "templates/" . str_replace('/', '&', $this->name) . '.tpl', 'w');
            if (@fwrite($f, $template) === false) {
                return false;
            }
        } else {
            return false;
        }
    }


    public function get($regex, &$match)
    {
        if ($regex == '' && $this->getRegex()=='' && $_SERVER['REQUEST_METHOD'] == 'GET') {
            return true;
        }

        if ($regex != '' && $_SERVER['REQUEST_METHOD'] == 'GET' && preg_match($regex, $this->getRegex(), $match)) {
            return true;
        }
        return false;
    }

    public function post($regex, &$match)
    {
        if ($regex == '' && $this->getRegex()=='' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && preg_match($regex, $this->getRegex(), $match)) {
            return true;
        }
        return false;
    }

    public function put($regex, &$match)
    {
        if ($regex == '' && $this->getRegex()=='' && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' && preg_match($regex, $this->getRegex(), $match)) {
            return true;
        }
        return false;
    }

    public function delete($regex, &$match)
    {
        if ($regex == '' && $this->getRegex()=='' && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && preg_match($regex, $this->getRegex(), $match)) {
            return true;
        }
        return false;
    }



    /**
     * Determine if exist module view
     *
     * @param string $name module name
     *
     * @return string|boolean
     */
    protected function existModuleView($name)
    {
        if (is_file(ROOT . 'modules/' . $name . '/view/main.tpl')) {
            return ROOT . 'modules/' . $name . '/view/main.tpl';
        } elseif (is_file(API . 'modules/' . $name . '/view/main.tpl')) {
            return API . 'modules/' . $name . '/view/main.tpl';
        }
    }

    /**
     * Determine if exist admin module view
     *
     * @param string $name module name
     *
     * @return string|boolean
     */
    protected function existAdminModuleView($name)
    {
        if (is_file(ROOT . 'modules/' . $name . '/view/main-admin.tpl')) {
            return ROOT . 'modules/' . $name . '/view/main-admin.tpl';

        } elseif (is_file(API . 'modules/' . $name . '/view/main-admin.tpl')) {
            return API . 'modules/' . $name . '/view/main-admin.tpl';

        }
    }

    /**
     * Determine if exist module controller
     *
     * @param string $name module name
     *
     * @return string|boolean
     */
    protected function existModuleController($name)
    {
        if (is_file(ROOT . 'modules/' . $name . '/controller/main.php')) {
            return ROOT . 'modules/' . $name . '/controller/main.php';
        } elseif (is_file(API . 'modules/' . $name . '/controller/main.php')) {
            return API . 'modules/' . $name . '/controller/main.php';
        }
    }

    /**
     * Determine if exist admin controller
     *
     * @param string $name module name
     *
     * @return string|boolean
     */
    protected function existAdminModuleController($name)
    {
        if (is_file(ROOT . 'modules/' . $name . '/controller/main-admin.php')) {
            return ROOT . 'modules/' . $name . '/controller/main-admin.php';
        } elseif (is_file(API . 'modules/' . $name . '/controller/main-admin.php')) {
            return API . 'modules/' . $name . '/controller/main-admin.php';
        }
    }

    /**
     * String format to URL
     *
     * @param string $s URL
     *
     * @return string
     */
    public static function tourl($s)
    {
        $s = trim($s);
        $s = mb_strtolower($s);
        $s = preg_replace("[á|à|â|ã|ª]", "a", $s);
        $s = preg_replace("[é|è|ê]", "e", $s);
        $s = preg_replace("[í|ì|î]", "i", $s);
        $s = preg_replace("[ó|ò|ô|õ|º]", "o", $s);
        $s = preg_replace("[ú|ù|û]", "u", $s);
        $s = preg_replace("[ñ]", "n", $s);
        $s = preg_replace("[ç]", "c", $s);
        $s = preg_replace("[']", "-", $s);

        $s = preg_replace('([^A-Za-z0-9[:space:]-])', '', $s);
        $s = str_replace(" ", '-', $s);

        return $s;
    }

    /**
     * Compile all pages
     *
     * @return boolean
     */
    public static function compileAll()
    {
        $view = new YujuView();
        $view->makeTemplate("compile-all-web-pages");
        return true;
    }


    /**
     * Generate Site Map
     *
     * @return string
     */
    public static function generateSiteMap()
    {
        $sitemap='<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $result = DB::query('SELECT name from page WHERE sitemap=1');
        while ($obj = $result->fetchObject()) {
            $sitemap.='<url><loc>'.DOMAIN.$obj->name.'</loc></url>';
        }
        $sitemap.='</urlset>';

        return $sitemap;
    }

    /**
     * Get number modules by schema
     *
     * @param string $schema schema name
     *
     * @return integer
     */
    public static function getNumModulesBySchema($schema)
    {
        $file = new File();
        $file->open(ROOT.'schema/'.$schema.'.tpl');
        if ($file->getSize()==0) {
            return 0;
        }
        preg_match_all("/__MOD(?P<digit>\d+)/", $file->getContent(), $output_array);

        return count($output_array[0]);
    }
}
