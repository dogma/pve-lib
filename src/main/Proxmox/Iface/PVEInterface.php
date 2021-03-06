<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 17/02/14
 * Time: 9:27 PM
 */

namespace Proxmox\Iface;


interface PVEInterface {

    function getNodes();
    function getNode($node);
    function getPools();
    function getStorage($node);
    function getTemplates($node,$storage);


    function createInstance($type,$template,$node,$options = array());
    function getInstance($node,$vmid);
    function deleteInstance($node,$vmid);
    function getInstances($node);
    function backupInstance();
    function setInstanceConfig($vmid,$configUpdates);

} 