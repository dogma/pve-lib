<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 16/02/14
 * Time: 6:46 PM
 */
namespace Proxmox;

use PHPUnit_Framework_TestCase;

class ServiceTest extends PHPUnit_Framework_TestCase {

    private $host = "";
    private $user = "";
    private $pass = "";
    private $realm = "";

    function __construct() {
    }

    function testServiceConnection() {
        $service = new Service();
        $service->setHost($this->host);
        $service->setUser($this->user);
        $service->setRealm($this->realm);
        $service->setPass($this->pass);
        $service->connect();
        $this->assertNotNull($service->getAuthData()['CSRFPreventionToken'],"CSRF Prevention Token missing");
        $this->assertNotNull($service->getAuthData()['ticket'],"Ticket is missing");
        $this->assertEquals("",$service->getAuthData()['username'],"Username doesn't match one sent");
    }

    function testStatsCollector() {

    }

}