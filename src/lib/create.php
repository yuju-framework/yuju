<?php
/**
 * Yuju create command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT:
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

use YujuFramework\YujuProject;
use YujuFramework\Error;

/**
 * Create project
 *
 * @return void
 */
function create()
{
    $project = new YujuProject;
    $api = substr(__DIR__, 0, strlen(__DIR__)-4).'/';
    /*
     * Project API or Standalone
     */
    $input_api = false;
    do {
        echo _('Project standalone (yes/no): ');
        $input = trim(fgets(STDIN));
        if ($input == _('yes')) {
            $input_api = true;
        } elseif ($input == _('no')) {
            $project->setApi($api);
            $input_api = true;
        }
    } while (!$input_api);
    
    $createadmin = false;
    /*
     * Project name
     */
    echo _('Project name: ');
    if (!$project->setName(trim(fgets(STDIN)))) {
        echo _('Invalid name') . "\n";
        exit;
    }

    /*
     * Mail administrator
     */
    do {
        echo _('Email administrator: ');
    } while (!$project->setAdminEmail(trim(fgets(STDIN))));

    /*
     * Time Zone
     */
    do {
        echo _('Timezone: ');
    } while (!$project->setTimeZone(trim(fgets(STDIN))));

    /*
     * Directory
     */
    echo _('Directory: ');
    if (!$project->setRoot(trim(fgets(STDIN)))) {
        echo _('Invalid directory') . "\n";
        exit;
    }
    echo _('Creating structure...')."\n";
    if (!$project->createStructure()) {
        echo _('Error creating structure') . "\n";
        echo Error::toString();
        exit;
    }

    /*
     * Domain
     */
    echo _('Domain: ');
    if (!$project->setDomain(trim(fgets(STDIN)))) {
        echo _('Invalid domain') . "\n";
        exit;
    }

    /*
     * Database type
     */
    do {
        echo _('Database Type (posibles values mysql, sqlserver): ');
    } while (!$project->setDBType(trim(fgets(STDIN))));

    /*
     * Database host
     */
    echo _('Database Host: ');
    $project->setDBHost(trim(fgets(STDIN)));

    /*
     * Database
     */
    echo _('Database name: ');
    $project->setDBName(trim(fgets(STDIN)));

    /*
     * Database User
     */
    echo _('Database user: ');
    $project->setDBUser(trim(fgets(STDIN)));

    /*
     * Database Password
     */
    echo _('Database password: ');
    $project->setDBPass(trim(fgets(STDIN)));
    
    
    echo _('Application language: [en_US] ');
    $project->setLanguage(trim(fgets(STDIN)));

    echo _('Creating database...') . "\n";
    if (!$project->createDatabase($createadmin)) {
        echo _('Error creating database') . "\n";
        exit;
    }
    $error = $project->setConfig();
    if ($error != 0) {
        echo _('Error setting config') . "\n";
        exit;
    }

    if (!$project->compileAll()) {
        echo _('Error compiling project');
        exit;
    }
    echo _('Project ') . $project->getName() . _(' created') . "\n";
}
