<?php require_once("includes/header.php");

$pictures = $photos->findAll();
?>
<div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnals row">
                <?php foreach ($pictures as $picture): ?>
                    <div class="col-xs-6 col-md-3">
                        <a href="photo.php?id=<?php echo $picture['id']?>" class="thumbnail">
                            <img src="<?php echo $picture['filename'] ?>" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
<!--            <div class="col-md-4">-->
<?php ////include("includes/sidebar.php"); ?>
<!--            </div>-->
        <!-- /.row -->
            <?php include("includes/footer.php"); ?>
