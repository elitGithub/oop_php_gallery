
        <hr>

        <!-- Footer -->
        <footer>
            <?php $time = new DateTimeImmutable() ?>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Copyright &copy; Your Website <?php echo $time->format('Y')?></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/<?php \Gallery\Utils::editorKey(); ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector:'#comment-form',
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        </script>
        <script defer src="js/scripts.js"></script>
</body>

</html>
