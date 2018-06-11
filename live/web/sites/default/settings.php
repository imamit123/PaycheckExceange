<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$client_data = [
  'live' => [
    'hostnames' => [
     "devsites-18.com"
      //"paycheckexchange.com", // << set preferred hostname first
      //"www.paycheckexchange.com",
      //"live-paycheck-exchange.clientsites.achieveagency.com"
    ],
    // 'redis' => [
    //   'host' => 'localhost',
    //   'prefix' => 'live-redis'
    // ],
    'database' => [
  	  //'database' => 'live_paycheck_exchange',
  	  //'username' => 'payxchg-live',
  	  //'password' => 'kbncU6aVy8ZwE9EPAA2qfjVmZJzYg8Ax',
  	  //'host' => 'localhost'
	'database' => 'devsites_consultprpcx-dev',
	'username' => 'devsites_userpcx',
	'password' => 'us^Wn}mxM)3z',
	'host' => 'localhost'
    
    ],
    'twig' => [
      'debug' => FALSE
    ],
    'security' => [
      'salt' => 'VA95ltrQYGthM9A4H1McviaaGEZNzA0-6pyYNk5X9TLj3QWQKboEU_a7H-pztlM8_sU2NKmIEg'
    ],
    'debug' => FALSE
  ],
  
];


/************************************* ATTN: DEVS **************************************/
/************************* OVERRIDES GO IN SETTINGS.LOCAL.PHP **************************/
/********************************* DO NOT MODIFY BELOW *********************************/

$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

$init = function($env) use ($client_data, &$settings, &$databases, &$config_directories) {
  $config_directories = [ CONFIG_SYNC_DIRECTORY => dirname(DRUPAL_ROOT) . '/config' ];
  $settings['install_profile'] = 'standard';
  $settings['hash_salt'] = $client_data[$env]['security']['salt'];

  // configure database
  $databases['default']['default'] = array(
    'driver' => 'mysql',
   // 'database' => $client_data[$env]['database']['database'],
   // 'username' => $client_data[$env]['database']['username'],
   // 'password' => $client_data[$env]['database']['password'],
   // 'host' => $client_data[$env]['database']['host'],
  	 'database' => 'devsites_consultprpcx-dev',
  	 'username' => 'devsites_userpcx',
  	 'password' => 'us^Wn}mxM)3z',
  	 'host' => 	   'devsites-18.com ',
  	 'pdo' => array(PDO::MYSQL_ATTR_COMPRESS => 1),
  );

  if ( in_array($env, ['dev', 'live']) ) {
    if ($env == 'live') {
      $host = $client_data[$env]['hostnames'][0];
      // if ($_SERVER['HTTP_HOST'] != $host || !isset($_SERVER['HTTP_X_SSL']) || $_SERVER['HTTP_X_SSL'] != 'ON' ) {
      //   header('HTTP/1.0 301 Moved Permanently');
      //   header("Location: https://{$host}{$_SERVER['REQUEST_URI']}");
      //   exit();
      // }
    }

    // configure redis
    //$settings['redis.connection']['interface'] = 'PhpRedis';
   // $settings['cache']['default'] = 'cache.backend.redis';
  //  $settings['redis.connection']['host'] = $client_data[$env]['redis']['host'];
  //  $settings['cache_prefix']['default'] = $client_data[$env]['redis']['prefix'];
  }

  // configure twig
  require_once DRUPAL_ROOT . '/modules/contrib/devel/kint/kint/Kint.class.php';
  Kint::$maxLevels = 5;
  $settings['twig_debug'] = $client_data[$env]['twig']['debug'];

  // configure client debug
  $settings['client_debug'] = $client_data[$env]['debug'];
};

if (isset($_SERVER['PANTHEON_ENVIRONMENT'])) {
  $init($_SERVER['PANTHEON_ENVIRONMENT']);
}
elseif (isset($_SERVER['HTTP_HOST'])) {
  foreach ($client_data as $env => $data) {
    foreach ($client_data[$env]['hostnames'] as $hostname) {
      if ($hostname == $_SERVER['HTTP_HOST']) {
        $init($env);
      }
    }
  }
}
$databases['default']['default'] = array (
  'database' => 'pcx',
  'username' => 'root',
  'password' => 'root',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
$settings['hash_salt'] = 'gUufhtpVBB1BEMdltEnJ5CcVI9BIEvm0StmZeCTRBmZr1amabgS3pLshwEbUb4yorPkjJ4OIQA';
$config_directories['sync'] = 'sites/default/files/config_8WRBQo0gSMjpEmUGraBbvpIco4nqGErUGQzvOf4OXlSDg-gMYRueWi97wYER1OTMozv1CWzTBA/sync';
