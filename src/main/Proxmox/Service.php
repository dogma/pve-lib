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

    function getNodes()
    {
        // TODO: Implement getNodes() method.
    }

    function getNode($node)
    {
        // TODO: Implement getNode() method.
    }

    function getPools()
    {
        // TODO: Implement getPools() method.
    }

    function getStorage($node)
    {
        // TODO: Implement getStorage() method.
    }

    function getTemplates($node, $storage)
    {
        // TODO: Implement getTemplates() method.
    }

    function createInstance()
    {
        // TODO: Implement createInstance() method.
    }

    function getInstance()
    {
        // TODO: Implement getInstance() method.
    }

    function deleteInstance()
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
}