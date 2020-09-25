<?php


namespace Gallery;

require_once 'Database.inc.php';

class Users extends Database
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

}