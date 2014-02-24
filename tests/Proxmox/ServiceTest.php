<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 24/02/14
 * Time: 10:17 PM
 */

namespace Proxmox;

use Proxmox\Models\Node;

use PHPUnit_Framework_TestCase;

class ServiceTest extends PHPUnit_Framework_TestCase {

    //These values need to be provided before tests can run
    //successfully.
    private $host = "";
    private $user = "";
    private $pass = "";
    private $realm = "";
    private $port = 8006;
    private $protocol = "https";
    private $userCodeCheck = "";
    private $testNode = "";
    private $testPool = "test";
    private $counter = 0;
    private $template = "";
    /** @var Service $service */
    private $service;

    function __construct() {
    }

    function setUp() {
        $cm= new CallManager($this->host, $this->port, $this->user, $this->pass);
        $cm->setProtocol($this->protocol);
        $cm->setRealm($this->realm);
        $this->service = new Service($cm);
    }

    function testGetNodes() {
        $nodes = $this->service->getNodes();
        $this->assertTrue(count($nodes) >= 1,"Not enough nodes returned");
        $this->assertTrue(array_key_exists("cpu",$nodes[0]),"No CPU value found, not node data");
    }

    function testGetNode() {
        $node = $this->service->getNode($this->testNode);
        $this->assertTrue($node instanceof Node,"Not a node");
    }

    function testGetStorage() {
        $storage = $this->service->getStorage($this->testNode);
        $this->assertTrue(is_array($storage),"Contains storage");
        $this->assertTrue(count($storage) > 0,"Contains storage");
    }

    function testGetTemplates() {
        $templates = $this->service->getTemplates($this->testNode,'local');
        $this->assertTrue(is_array($templates),"Contains templates");
        $this->assertTrue(count($templates) > 0,"Has at least one template");
        $this->assertTrue($templates[0]['format'] == 'tgz',"Template format not as expected (tgz)");
        $this->assertTrue(stripos($templates[0]['volid'],"local:vztmpl") >= 0,"Does not appear to be a correct template");
    }

    function testNextId() {
        $idA = $this->service->getNextVmid();
        $idB = $this->service->getNextVmid();
        $this->assertEquals($idA,$idB,"Next IDs should be equal");
    }

    function testCreateContainer() {
        $templates = $this->service->getTemplates($this->testNode,'local');
        $this->service->createInstance("openvz",$this->template,"c02",array(
            'cpus'=>2,
            'hostname'=>'test',
            'memory'=>'1024',
            'onboot'=>true,
            'password'=>'ungara13',
            'disk'=>5,
            'description'=>"test container creation",
            'ip_address'=>'10.1.1.200',
            'storage'=>'local'
        ));
        $this->assertTrue(is_array($templates),"Contains templates");
        $this->assertTrue(count($templates) > 0,"Has at least one template");
        $this->assertTrue($templates[0]['format'] == 'tgz',"Template format not as expected (tgz)");
        $this->assertTrue(stripos($templates[0]['volid'],"local:vztmpl") >= 0,"Does not appear to be a correct template");
    }


}