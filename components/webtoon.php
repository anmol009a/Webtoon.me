<div class="webtoon col">
    <!-- <?php include 'components/webtoon_img.php'; ?> -->
    <h5 class="webtoon-title text-truncate">
        <a href="<?= $webtoon['url'] ?>" class="text-dark text-decoration-none fs-6 fw-semibold"  rel="noopener" target="_blank" title="<?= $webtoon['title'] ?>">
            <?= $webtoon['title'] ?>
        </a>
    </h5>
    <ul class="list-group">
        <?php
        foreach ($webtoon['chapters'] as $chapter) {
            include 'components/chapter.php';
        }
        ?>
    </ul>
</div>