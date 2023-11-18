<div class="webtoon py-2">
    <!-- <?php include 'component/webtoon_img.php'; ?> -->
    <h5 class="webtoon-title">
        <a href="<?= $webtoon['url'] ?>" class="text-dark text-decoration-none" target="blank">
            <?= $webtoon['title'] ?>
        </a>
    </h5>
    <ul class="list-group">
        <?php
        foreach ($webtoon['chapters'] as $chapter) {
            include 'component/chapter.php';
        }
        ?>
    </ul>
</div>