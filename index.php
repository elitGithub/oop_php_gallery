<?php use Gallery\Paginate;

require_once("includes/header.php");

$page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;

$totalPhotos = $photos->count()['totalRecords'];

$paginator = new Paginate($page, $items_per_page, $totalPhotos);
$pictures = $photos->findAll($paginator->itemsPerPage, $paginator->offset());
?>
<div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="row">
                <?php foreach ($pictures as $picture): ?>
                    <div class="col-xs-6 col-md-3">
                        <a href="photo.php?id=<?php echo $picture['id']?>" class="thumbnail">
                            <img class="thumbnail" src="<?php echo $picture['filename'] ?>" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
</div>
<div class="row">
    <ul class="pager">
        <?php
        if ($paginator->totalPages() > 1) {
            if ($paginator->hasNextPage()) {

                echo "<li class='next'><a href='index.php?page={$paginator->next()}'>Next</a></li>";
            }

            for ($i = 1; $i <= $paginator->totalPages(); $i++) {
                if ($i === $paginator->currentPage) {
                    echo "<li class='active'><a class='current-page' href='index.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }
            if ($paginator->hasPreviousPage()) {
                echo "<li class='previous'><a href='index.php?page={$paginator->previous()}'>Previous</a></li>";
            }
        }
            ?>
    </ul>
</div>
            <!-- Blog Sidebar Widgets Column -->
<!--            <div class="col-md-4">-->
<?php ////include("includes/sidebar.php"); ?>
<!--            </div>-->
        <!-- /.row -->
            <?php include("includes/footer.php"); ?>
