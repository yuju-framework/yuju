<?php

/**
 * Yuju create command line File
 *
 * PHP version 5
 *
 * Copyright individual contributors as indicated by the @authors tag.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: create.php 193 2014-10-23 20:13:28Z danifdez $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
$project = new Yuju_Project();
$project->setApi(substr(__FILE__, 0, strlen(__FILE__) - 14));

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
 * Database host
 */
echo _('Database Host: ');
$project->setDBHost(trim(fgets(STDIN)));

/*
 * Database type
 */
do {
    echo _('Database Type (posibles values mysql, sqlserver, oracle (not implemented yet): ');
} while (!$project->setDBType(trim(fgets(STDIN))));

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

echo _('Create admin pages: [Y/n]');
if (trim(fgets(STDIN)) == "y" || trim(fgets(STDIN)) == "") {
    $createadmin = true;
    echo _('Admin section password: ');
    $project->setAdminpass(sha1(trim(fgets(STDIN))));    
}

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
