<?php use Gallery\Comments;

require_once("includes/header.php");
$comments = new Comments();
$photos->id = $comments->photo_id = $_GET['id'];
$photos->retrieveEntityInfo();

?>
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
                <!-- Blog Post -->
                <!-- Title -->
                <h1><?php echo $photos->title?></h1>
                <!-- Author -->
                <p class="lead">
                    by <a href="#">Start Bootstrap</a>
                </p>
                <hr>
                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $photos->created_at?></p>
                <hr>
                <!-- Preview Image -->
                <img class="img-responsive" src="<?php echo $photos->filename ?>" alt="">
                <hr>
                <!-- Post Content -->
                <p class="lead"><?php $photos->caption; ?></p>
                <p><?php echo $photos->description; ?></p>
                <hr>
                <!-- Blog Comments -->
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" id="add_comment">
                        <div class="form-group">
                            <label for="author">Your Name</label>
                            <input type="text" class="form-control" required minlength="2" name="author" id="author">
                        </div>
                        <div class="form-group">
                            <label for="comment-form">Your Message:</label>
                                <textarea id="comment-form" name="comment_content" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>
                <!-- Posted Comments -->
                <!-- Comment -->
                <?php $userComments = $comments->getCommentsForPhoto(); ?>
                <?php foreach ($userComments as $comment): ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment['author']?>
                            <small><?php echo $comment['created_at']?></small>
                        </h4>
                        <?php echo $comment['comment_content']?>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- Comment -->
            </div>
            <!-- Blog Sidebar Widgets Column -->
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
 <?php require_once 'includes/footer.php'?>