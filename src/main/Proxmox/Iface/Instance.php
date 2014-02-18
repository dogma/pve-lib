<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 17/02/14
 * Time: 9:47 PM
 */

namespace Proxmox\Iface;

/**
 * An instance can be either a Full VM or a Container. This provides the abstract elements for both.
 * Interface Instance
 * @package Proxmox\Iface
 */
interface Instance {

    function getNode();
    function setNode();

    function getStatus();

    function start();
    function stop();
    function restart();

    function backup();

}