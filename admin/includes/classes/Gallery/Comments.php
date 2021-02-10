<?php


namespace Gallery;


class Comments extends Database
{
    protected string $table = 'comments';
    protected array $fillables = ['photo_id', 'author', 'comment_content'];
    public int $photo_id;
    public string $author;
    public string $comment_content;

    public function getAllComments() {
        $query = 'SELECT comments.*, p.filename FROM comments JOIN photos p on comments.photo_id = p.id';
        $this->query($query);
        return $this->resultSet();
    }

    public function getCommentsForPhoto() {
        if (!$this->photo_id) {
            return [];
        }

        $query = 'SELECT comments.*, p.filename FROM comments JOIN photos p on comments.photo_id = p.id WHERE comments.photo_id = :id';
        $this->query($query);
        $this->bind(':id', $this->photo_id);
        return $this->resultSet();
    }
}