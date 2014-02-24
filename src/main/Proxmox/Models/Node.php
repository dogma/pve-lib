<?php
/**
 * Created by PhpStorm.
 * User: gerwood
 * Date: 17/02/14
 * Time: 9:47 PM
 */

namespace Proxmox\Models;


class Node {

    public $id;
    public $services;
    /** @var Array $data provides information about the node */
    public $data;

    /**
     * Array of containers running on the node
     * @var
     */
    public $containers;

    /**
     * Provides instance objects for all vms and containers on the machine.
     * @var
     */
    public $instances;

    /**
     * Storage instance available on the node
     * @var
     */
    public $storage;
} 