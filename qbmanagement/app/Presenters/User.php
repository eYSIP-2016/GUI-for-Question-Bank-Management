<?php

namespace App\Presenters;

use Sofa\Revisionable\Laravel\Presenter;

class User extends Presenter {

    protected $labels = [
        'name'        => 'Name of the User',
        'username'    => 'Username for the system',
        'email'      => 'Email-id of the user',
        'version'   => 'Tag-id',
    ];

    protected $passThrough = [
        'version'        => 'tags.name',
        /**'customer_id'    => 'customer.name',
        'responsible_id' => 'serviceman.name',
        'status_id'      => 'status.name',**/
    ];

    protected $actions = [
        'created'  => 'User Created',
        'updated'  => 'User Updated',
        'deleted'  => 'User deleted',
        'restored' => 'User Restored',
    ];

}