<?php


namespace Gallery;


class Comments extends Database
{
    protected string $table = 'comments';
    protected $fillables = ['photo_id', 'author', 'body'];
    public int $photo_id;
    public string $author;
    public string $body;
}