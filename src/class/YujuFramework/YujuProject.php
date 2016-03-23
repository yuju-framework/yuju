<?php
/**
 * YujuProject File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

namespace YujuFramework;

use YujuFramework\Utils;
use YujuFramework\YujuView;
use YujuFramework\Dir;
use YujuFramework\File;
use YujuFramework\DataBase\DB;

 /**
  * YujuProject Class
  *
  * @category Core
  * @package  YujuFramework
  * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
  * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
  * @link     https://github.com/yuju-framework/yuju
  * @since    version 1.0
  */
class YujuProject
{

    /**
     * Project name
     *
     * @var string
     */
    protected $name;

    /**
     * Email administrator
     *
     * @var string
     */
    protected $admin_email;

    /**
     * Project directory
     *
     * @var string
     */
    protected $root;

    /**
     * Project URL
     *
     * @var string
     */
    protected $domain;

    /**
     * Database host
     *
     * @var string
     */
    protected $dbhost;

    /**
     * Database type
     *
     * @var string
     */
    protected $dbtype;

    /**
     * Database name
     *
     * @var string
     */
    protected $dbname;

    /**
     * Database user
     *
     * @var string
     */
    protected $dbuser;

    /**
     * Database password
     *
     * @var string
     */
    protected $dbpass;

    /**
     * Directory API
     *
     * @var string
     */
    protected $api;
    protected $adminpass;
    protected $language;
    protected $timezone;

    /**
     * Getter project name
     *
     * @return string
     * @since version 1.0
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter project name
     *
     * @param string $name project name
     *
     * @return boolean
     * @since version 1.0
     */
    public function setName($name)
    {
        $this->name=$name;
        return true;
    }
    
    /**
     * Getter project timezone
     *
     * @return string
     * @since version 1.0
     */
    public function getTimeZone()
    {
        return $this->timezone;
    }

    /**
     * Setter project timezone
     *
     * @param string $name project timezone
     *
     * @return boolean
     * @since version 1.0
     */
    public function setTimeZone($name)
    {
        $this->timezone=$name;
        return true;
    }

    /**
     * Getter root directory
     *
     * @return string
     * @since version 1.0
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Setter root directory
     *
     * @param string $root root directory
     *
     * @return boolean
     * @since version 1.0
     */
    public function setRoot($root)
    {
        if (substr($root, strlen($root) - 1) != '/') {
            $root=$root.'/';
        }
        $this->root=$root;
        return true;
    }

    /**
     * Getter administrator email
     *
     * @return string
     * @since version 1.0
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * Setter administrator email
     *
     * @param string $email email
     *
     * @return boolean
     * @since version 1.0
     */
    public function setAdminEmail($email)
    {
        if (Utils::validEmail($email)) {
            $this->admin_email=$email;
            return true;
        }
        return false;
    }

    /**
     * Getter API directory
     *
     * @return string
     * @since version 1.0
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Setter API directory
     *
     * @param string $api API directory
     *
     * @return boolean
     * @since version 1.0
     */
    public function setApi($api)
    {
        if (substr($api, strlen($api) - 1) != '/') {
            $api=$api.'/';
        }
        $this->api=$api;
        return true;
    }

    /**
     * Getter domain
     *
     * @return string
     * @since version 1.0
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Setter domain
     *
     * @param string $domain domain
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDomain($domain)
    {
        if (substr($domain, strlen($domain) - 1) != '/') {
            $domain=$domain.'/';
        }
        $domain=Utils::validURI($domain);
        if ($domain === false) {
            return false;
        } else {
            $this->domain=$domain;
            return true;
        }
    }

    /**
     * Getter database host
     *
     * @return string
     * @since version 1.0
     */
    public function getDBHost()
    {
        return $this->dbhost;
    }

    /**
     * Setter database host
     *
     * @param string $dbhost database host
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDBHost($dbhost)
    {
        $this->dbhost=$dbhost;
        return true;
    }

    /**
     * Getter database type
     *
     * @return string
     * @since version 1.0
     */
    public function getDBType()
    {
        return $this->dbtype;
    }

    /**
     * Setter database type
     *
     * @param string $dbtype database type
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDBType($dbtype)
    {
        $return=false;
        switch ($dbtype) {
            case 'mysql':
            case 'sqlserver':
            case 'oracle':
                $this->dbtype=$dbtype;
                $return=true;
                break;
            default:
                $return=false;
                break;
        }
        return $return;
    }

    /**
     * Getter database name
     *
     * @return string
     * @since version 1.0
     */
    public function getDBName()
    {
        return $this->dbname;
    }

    /**
     * Setter database name
     *
     * @param string $dbname database name
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDBName($dbname)
    {
        $this->dbname=$dbname;
        return true;
    }

    /**
     * Getter database user
     *
     * @return string
     * @since version 1.0
     */
    public function getDBUser()
    {
        return $this->dbuser;
    }

    /**
     * Setter database user
     *
     * @param string $dbuser database user
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDBUser($dbuser)
    {
        $this->dbuser=$dbuser;
        return true;
    }

    /**
     * Getter database password
     *
     * @return string
     * @since version 1.0
     */
    public function getDBPass()
    {
        return $this->dbpass;
    }

    /**
     * Setter database password
     *
     * @param string $dbpass database password
     *
     * @return boolean
     * @since version 1.0
     */
    public function setDBPass($dbpass)
    {
        $this->dbpass=$dbpass;
        return true;
    }

    /**
     * Getter admin pass
     *
     * @return string
     */
    public function getAdminpass()
    {
        return $this->adminpass;
    }

    /**
     * Setter admin pass
     *
     * @param string $adminpass admin pass
     *
     * @return void
     */
    public function setAdminpass($adminpass)
    {
        $this->adminpass=$adminpass;
    }

    /**
     * Getter language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Setter language
     *
     * @param string $language language
     *
     * @return void
     */
    public function setLanguage($language)
    {
        if (YujuProject::isLanguageSupported($language)) {
            $this->language=$language;
        } else {
            $this->language="en_US";
        }
    }

    /**
     * Create project structure
     *
     * @return boolean
     * @since version 1.0
     */
    public function createStructure()
    {
        if (!Dir::exist($this->root)) {
            if (!Dir::mkdir($this->root, true)) {
                Error::setError('createStructure', _('Error creating root folder '.$this->root));
                return false;
            }
        }
        
        if (!Dir::mkdir($this->root.'cache', true)) {
            Error::setError('createStructure', _('Error creating cache folder'));
            return false;
        }
        if (!Dir::mkdir($this->root.'class', true)) {
            Error::setError('createStructure', _('Error creating class folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'compiled', true)) {
            Error::setError('createStructure', _('Error creating compiled folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'conf', true)) {
            Error::setError('createStructure', _('Error creating conf folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'htdocs', true)) {
            Error::setError('createStructure', _('Error creating htdocs folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'include', true)) {
            Error::setError('createStructure', _('Error creating include folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'modules', true)) {
            Error::setError('createStructure', _('Error creating module folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'schema', true)) {
            Error::setError('createStructure', _('Error creating schema folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'templates', true)) {
            Error::setError('createStructure', _('Error creating templates folder'));
            return false;
        }
        
        if (!Dir::mkdir($this->root.'locales', true)) {
            Error::setError('createStructure', _('Error creating locales folder'));
            return false;
        }
        
        if (!File::copy($this->api.'lib/template/.htaccess', $this->root.'htdocs/.htaccess')) {
            Error::setError('createStructure', _('Error copy .htaccess on htdocs folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/index.php', $this->root.'htdocs/index.php')) {
            Error::setError('createStructure', _('Error copy index.php on htdocs folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/rpc.php', $this->root.'htdocs/rpc.php')) {
            Error::setError('createStructure', _('Error copy rpc.php on htdocs folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/default.tpl', $this->root.'schema/default.tpl')) {
            Error::setError('createStructure', _('Error copy on schema folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/not-found.tpl', $this->root.'schema/not-found.tpl')) {
            Error::setError('createStructure', _('Error copy on schema folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/text.tpl', $this->root.'schema/text.tpl')) {
            Error::setError('createStructure', _('Error copy text.tpl on schema folder'));
            return false;
        }
        if (!File::copy($this->api.'lib/template/site.php', $this->root.'conf/site.php')) {
            Error::setError('createStructure', _('Error copy site.php on conf folder'));
            return false;
        }
        if (!Dir::copy($this->api.'lib/template/locales/', $this->root.'/locales/')) {
            Error::setError('createStructure', _('Error copy on locale folder'));
            return false;
        }
        if (!Dir::copy($this->api.'lib/template/html', $this->root.'modules')) {
            Error::setError('createStructure', _('Error copy on module folder'));
            return false;
        }
        if (!Dir::chmod($this->root.'compiled/', 0777)) {
            Dir::rmdir($this->root);
            return false;
        }
        return true;
    }

    /**
     * Create project database
     *
     * @param boolean $adminSect create database with admin secction
     *
     * @return boolean
     * @since version 1.0
     */
    public function createDatabase()
    {
        if (!DB::connection($this->dbtype, $this->dbhost, $this->dbuser, $this->dbpass, $this->dbname)) {
            if (!DB::connection($this->dbtype, $this->dbhost, $this->dbuser, $this->dbpass)) {
                return false;
            }
            if (!DB::createSchema($this->dbname)) {
                return false;
            }
            if (!DB::selectDB($this->dbname)) {
                return false;
            }
        } else {
            if (!DB::connection($this->dbtype, $this->dbhost, $this->dbuser, $this->dbpass, '')) {
                return false;
            }
            if (!DB::selectDB($this->dbname)) {
                return false;
            }
        }
        DB::beginTransaction();
        $sql='CREATE TABLE `page` (';
        $sql.='`name` varchar(300) NOT NULL,';
        $sql.='`regex` bit(1) DEFAULT NULL,';
        $sql.='`title` varchar(200) DEFAULT NULL,';
        $sql.='`schema` varchar(100) NOT NULL,';
        $sql.='`type` varchar(100) NOT NULL,';
        $sql.='`html` mediumtext,';
        $sql.='`cssfiles` MEDIUMTEXT,';
        $sql.='`jsfiles` MEDIUMTEXT,';
        $sql.='`keyword` varchar(400) DEFAULT NULL,';
        $sql.='`description` varchar(400) DEFAULT NULL,';
        $sql.='`modules` mediumtext,';
        $sql.='`parent` varchar(300) DEFAULT NULL,';
        $sql.='`sitemap` tinyint(1) DEFAULT NULL,';
        $sql.='  PRIMARY KEY (`name`)';
        $sql.=') ENGINE=MyISAM DEFAULT CHARSET=utf8;';
        if (!DB::query($sql)) {
            DB::rollback();
            return false;
        }
        $sql='INSERT INTO `page` (`name`,`regex`,`title`,`schema`,`type`,`html`,`modules`,`parent`,`sitemap`) ';
        $sql.='VALUES(\'index\',0,\'Home\',\'default\',\'html\',\'\',';
        $sql.='\'{"MOD1":[{"html": {"value": "<p>Hello World!</p>"}}]}\',\'\',1)';
        if (!DB::query($sql)) {
            DB::rollback();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * Set project config
     *
     * @return boolean
     * @since version 1.0
     */
    public function setConfig()
    {
        if (!File::exist($this->root.'conf/site.php')) {
            return -1;
        }
        $config_file=new File();
        if (!$config_file->open($this->root.'conf/site.php')) {
            return -2;
        }
        if (!Utils::validEmail($this->admin_email)) {
            return -3;
        }
        $newfile='';
        //Output a line of the file until the end is reached
        while (!$config_file->eof()) {

            $line=$config_file->getLine();
            $new=false;
            $vars=array(
                'PROJECT_NAME'=>&$this->name,
                'API'=>&$this->api,
                'MAILADM'=>&$this->admin_email,
                'DOMAIN'=>&$this->domain,
                'ROOT'=>&$this->root,
                'DBHOST'=>&$this->dbhost,
                'DBTYPE'=>&$this->dbtype,
                'DBUSER'=>&$this->dbuser,
                'DBPASS'=>&$this->dbpass,
                'DBDATA'=>&$this->dbname,
                'ADMINPASS'=>&$this->adminpass,
                'LANGUAGE'=>&$this->language,
                'TIMEZONE'=>&$this->timezone,
            );
            foreach ($vars as $key => $value) {
                $newline=preg_replace(
                    '/^define\(\''.$key.'\', \'(.*)\'\);/',
                    'define(\''.$key.'\', \''.$value.'\');',
                    $line
                );
                if ($newline != $line) {
                    $newfile.=$newline;
                    $new=true;
                }
            }
            if ($new == false) {
                $newfile.=$line;
            }
        }
        $config_file->setContent($newfile);
        if (!$config_file->save()) {
            return -4;
        }
        $config_file->close();

        if (!File::exist($this->root.'conf/site.php')) {
            return -1;
        }
        $trans_file=new File();
        if (!$trans_file->open($this->root.'locales/translate.sh')) {
            return -2;
        }
        if (!Utils::validEmail($this->admin_email)) {
            return -3;
        }
        $newfile='';
        //Output a line of the file until the end is reached
        while (!$trans_file->eof()) {

            $line=$trans_file->getLine();
            $new=false;
            $vars=array(
                'API'=>&$this->api,
                'PROJECT'=>&$this->root,
            );
            foreach ($vars as $key => $value) {
                $newline = preg_replace('/^'.$key.'=(.*)/', $key.'="'.$value.'"', $line);
                if ($newline != $line) {
                    $newfile.=$newline;
                    $new=true;
                }
            }
            if ($new == false) {
                $newfile.=$line;
            }
        }
        $trans_file->setContent($newfile);
        if (!$trans_file->save()) {
            return -4;
        }
        $trans_file->close();
        return 0;
    }

    /**
     * Compile all pages
     *
     * @return boolean
     * @since version 1.0
     */
    public function compileAll()
    {
        include_once $this->root.'conf/site.php';
        return YujuView::compileAll();
    }

    /**
     * Get modules
     *
     * @param string $root root directory
     *
     * @return array
     */
    public static function getAllModules($root)
    {
        $modules = array();
        $directories = Dir::listDirectories($root.'modules');
        foreach ($directories as $dir) {
            $explode = explode('/', $dir);
            $modules[] = $explode[count($explode)-1];
        }
        if (defined("API")) {
            $directories = Dir::listDirectories(API.'modules');
            foreach ($directories as $dir) {
                $explode = explode('/', $dir);
                if (!in_array($explode[count($explode)-1], $modules)) {
                    $modules[] = $explode[count($explode)-1];
                }
            }
        }
        return $modules;
    }

    /**
     * Get public modules
     *
     * @param string $root root directory
     *
     * @return array
     */
    public static function getAllPublicModules($root)
    {
        $modules = array();
        $directories = Dir::listDirectories($root.'modules');
        foreach ($directories as $dir) {
            $explode = explode('/', $dir);
            if (substr($explode[count($explode)-1], 0, 5)!= 'admin-'
                && substr($explode[count($explode)-1], 0, 4)!= 'rpc-'
            ) {
                $modules[] = $explode[count($explode)-1];
            }
        }
        if (defined("API")) {
            $directories = Dir::listDirectories(API.'modules');
            foreach ($directories as $dir) {
                $explode = explode('/', $dir);
                if (substr($explode[count($explode)-1], 0, 6)!= 'admin-'
                    && substr($explode[count($explode)-1], 0, 4)!= 'rpc-'
                    && !in_array($explode[count($explode)-1], $modules)
                ) {
                    $modules[] = $explode[count($explode)-1];
                }
            }
        }
        return $modules;
    }
    
    /**
     * Check if lagnuage is supported
     *
     * @param string $language URI
     *
     * @return boolean
     * @since version 1.0
     */
    public static function isLanguageSupported($language)
    {
        $file = new File();
        $root = substr(__DIR__, 0, strlen(__DIR__)-20);
        $file->open($root . "/lib/languages.txt");
        while (!$file->eof()) {
            $line = $file->getLine();
            if ($line == $language) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the list of the supported languages
     *
     * @return boolean return filter URI or false
     * @since version 1.0
     */
    public static function getSupportedLanguages()
    {
        $file = new File();
        $file->open(__DIR__ . "/lib/languages.txt");
        $lang = array();
        while (!$file->eof()) {
            $line = $file->getLine();
            $lang[] = $line;
        }
        return $lang;
    }
}
