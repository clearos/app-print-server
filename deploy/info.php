<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'print_server';
$app['version'] = '2.1.14';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('print_server_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('print_server_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_print');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['print_server']['title'] = $app['name'];
$app['controllers']['settings']['title'] = lang('base_settings');
$app['controllers']['policy']['title'] = lang('base_app_policy');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-groups',
    'app-users',
    'app-network', 
);

$app['core_requires'] = array(
    'app-certificate-manager-core',
    'app-events-core',
    'app-groups-core',
    'app-network-core >= 1:1.6.0',
    'app-print-server-plugin-core',
    'app-users-core',
    'cups >= 1.4.2-44.v6.1',
    'csplugin-filewatch',
    'foomatic',
);

$app['core_directory_manifest'] = array(
    '/etc/clearos/print_server.d' => array(),
    '/var/clearos/print_server' => array(),
    '/var/clearos/print_server/backup/' => array(),
    '/var/cache/cups' => array(
        'mode' => '0775',
        'group' => 'lp',
    ),
);

$app['core_file_manifest'] = array(
    'print_server.conf' => array (
        'target' => '/etc/clearos/print_server.conf',
        'config' => TRUE,
        'config_params' => 'noreplace',
    ),
    'accounts-event'=> array(
        'target' => '/var/clearos/events/accounts/print_server',
        'mode' => '0755'
    ),
    'network-configuration-event'=> array(
        'target' => '/var/clearos/events/network_configuration/print_server',
        'mode' => '0755'
    ),
    'cupsd.listen.conf'=> array(
        'target' => '/etc/cups/cupsd.listen.conf',
        'config' => TRUE,
        'config_params' => 'noreplace'
    ),
    'cups.php'=> array('target' => '/var/clearos/base/daemon/cups.php'),
    'cupsd.location.conf'=> array('target' => '/etc/cups/cupsd.location.conf'),
    'cupsd.policy.conf'=> array('target' => '/etc/cups/cupsd.policy.conf'),
    'filewatch-print-server-configuration.conf'=> array('target' => '/etc/clearsync.d/filewatch-print-server-configuration.conf'),
    'filewatch-print-server-printers.conf'=> array('target' => '/etc/clearsync.d/filewatch-print-server-printers.conf'),
);

$app['delete_dependency'] = array(
    'app-print-server-core',
    'app-print-server-plugin-core',
    'cups'
);
