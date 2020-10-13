<?php


namespace Gallery;


class Photo extends Database
{
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

     /**
     * @var string
     */
    protected string $table = 'photos';

}