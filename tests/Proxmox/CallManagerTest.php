<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 16/02/14
 * Time: 6:46 PM
 */
namespace Proxmox;

use PHPUnit_Framework_TestCase;

class CallManagerTest extends PHPUnit_Framework_TestCase {

    //These values need to be provided before tests can run
    //successfully.
    private $host = "10.1.1.2";
    private $user = "bosunpete";
    private $pass = "ungara13";
    private $realm = "pve";
    private $port = 8006;
    private $protocol = "https";
    private $userCodeCheck = "bosunpete@pve";
    private $testNode = "c02";
    private $testPool = "test";
    /** @var Service $service */
    private $service;

    function __construct() {
    }

    function setUp() {
        $this->service = new CallManager($this->host, $this->port, $this->user, $this->pass);
        $this->service->setProtocol($this->protocol);
        $this->service->setRealm($this->realm);
        $this->service->connect();
    }

    function testServiceConnection() {
        $this->assertNotNull($this->service->getAuthData()['CSRFPreventionToken'],"CSRF Prevention Token missing");
        $this->assertNotNull($this->service->getAuthData()['ticket'],"Ticket is missing");
        $this->assertEquals($this->userCodeCheck,$this->service->getAuthData()['username'],"Username doesn't match one sent");
    }

    function testStatsCollector() {
        $output = $this->service->get("nodes/".$this->testNode."/status");
        $this->assertEquals(2,$output['data']['cpuinfo']['sockets'],"Incorrect cpu sockts");
    }

    function testGetContainers() {
        $output = $this->service->get("nodes/".$this->testNode."/openvz");
        $this->assertGreaterThan(1,count($output['data']),"There was more than one container found");
    }

    function testPools() {
        $output = $this->service->get("pools/");
        foreach($output['data'] as $box) {
            if($box['poolid'] == $this->testPool) {
                $this->assertTrue(true);
                return;
            }
        }
        $this->assertTrue(false,"Test (".$this->testPool." pool was not found");
    }

    function testLoadTestPool() {
        $output = $this->service->get("pools/".$this->testPool);
        $this->assertNotNull($output,"Pool returned");
    }

}