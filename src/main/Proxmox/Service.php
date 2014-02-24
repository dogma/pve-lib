<?php
/**
 *
 * Created by PhpStorm.
 * User: gerwood
 * Date: 16/02/14
 * Time: 6:43 PM
 */
namespace Proxmox;

use Proxmox\Iface\PVEInterface;
use Proxmox\Models\Node;

/**
 * Provides a wrapper service for managing the main calls to and from the api.
 * It makes use of the CallManager to make the actual calls, handle initial
 * authentication and provide authentication information back to the server
 * when needed. As a result the Service tries to provide just a wrapper
 * around the calls themselves to all convenient access through a PHP/OOP API
 *
 * Class Service
 * @package Proxmox
 */
class Service implements PVEInterface {

    /** @var CallManager $callManager */
    private $callManager;

    function __construct(CallManager $callManager) {
        $this->callManager = $callManager;
        $this->callManager->connect();
    }

    function getNodes()
    {
        $data = $this->callManager->get("nodes");
        $nodes = $data['data'];
        return $nodes;
    }

    function getNode($nodeName)
    {
        $nodes = $this->getNodes();
        $found = false;
        foreach($nodes as $nodeData) {
            if($nodeData['node'] == $nodeName) {
                $found = $nodeData;
                break;
            }
        }

        if(!$found) { return null; }

        $data = $this->callManager->get("nodes/".$nodeName);
        $node = new Node();
        $node->id = $nodeName;
        $node->data = $found;
        $node->calls = $data['data'];

        $services = $this->callManager->get("nodes/".$nodeName."/services");
        $node->services = $services['data'];

        $containers = $this->callManager->get("nodes/".$nodeName."/openvz");
        $node->containers = $containers['data'];
        $storage = $this->callManager->get("nodes/".$nodeName."/storage");
        $node->storage = $storage['data'];
        return $node;
    }

    function getPools()
    {
        $data = $this->callManager->get("pools");
        return $data['data'];
    }

    function getStorage($node)
    {
        $data = $this->callManager->get("nodes/$node/storage");
        return $data['data'];
    }

    function getTemplates($node, $storage)
    {
        $data = $this->callManager->get("nodes/$node/storage/$storage/content");
        $templates = $data['data'];
        return $templates;
    }

    function getNextVmid()
    {
        $data = $this->callManager->get("cluster/nextid");
        $templates = $data['data'];
        return $templates;
    }

    function createInstance($type,$template,$node,$options = array())
    {
        if($type == "openvz") {
            echo "Trialing OPENVZ Container";
            $vmid = $this->callManager->get("cluster/nextid");
            $vmid = $vmid['data'];

            $request = array(
                'ostemplate'=>$template,
                'vmid'=>$vmid,
            );

            $request = array_merge($request,$options);
            $this->callManager->post("nodes/$node/openvz",$request);
        } elseif($type == "kvm") {

        }
    }

    function getInstance($node,$vmid)
    {
        // TODO: Implement getInstance() method.
    }

    function deleteInstance($node,$vmid)
    {
        // TODO: Implement deleteInstance() method.
    }

    function backupInstance()
    {
        // TODO: Implement backupInstance() method.
    }

    function setInstanceConfig($instanceId, $configUpdates)
    {
        // TODO: Implement setInstanceConfig() method.
    }

    function getInstances($node)
    {
        // TODO: Implement getInstances() method.
    }
}