<?php


namespace Gallery;


class Comments extends Database
{
    protected string $table = 'comments';
    protected $fillables = ['photo_id', 'author', 'body'];
    public int $photo_id;
    public string $author;
    public string $body;

    public function getAllComments() {
        $query = 'SELECT comments.*, p.filename FROM comments JOIN photos p on comments.photo_id = p.id';
        $this->query($query);
        return $this->resultSet();
    }
}