<?php

namespace Album;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Album\Model\AclService;
			
 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     public function getServiceConfig()
     {
     	return array(
     			'factories' => array(
     					'Album\Model\AlbumTable' =>  function($sm) {
     						$tableGateway = $sm->get('AlbumTableGateway');
     						$table = new AlbumTable($tableGateway);
     						return $table;
     					},
     					'AlbumTableGateway' => function ($sm) {
     						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
     						$resultSetPrototype = new ResultSet();
     						$resultSetPrototype->setArrayObjectPrototype(new Album());
     						return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
     					},
     					
     					'Album\Model\MyAuthStorage' => function($sm){
     						return new \Album\Model\MyAuthStorage('zf_tutorial');
     					},
     					 
     					'AuthService' => function($sm) {
     						//My assumption, you've alredy set dbAdapter
     						//and has users table with columns : user_name and pass_word
     						//that password hashed with md5
     						$dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
     						$dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
     								'users','user_name','pass_word','role','MD5(?)');
     						 
     						$authService = new AuthenticationService();
     						$authService->setAdapter($dbTableAuthAdapter);
     						$authService->setStorage($sm->get('Album\Model\MyAuthStorage'));
     					
     						return $authService;
     					},
     					
     					'AclService' => function($sm){
     						$acl = new AclService();
     						return $acl;
     					},
//      					'AuthService' => function ($sm) {
//      					$authService= new AuthenticationService();
//      					//$authService->setAdapter (new TestAuthAdapter('log','pass'));
//      					$authService-> setStorage(new Session());
     					
//      					return $authService;
//     					},
     			),
     	);
     }
     
 }
 
 ?>