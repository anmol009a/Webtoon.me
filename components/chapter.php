<li class="chapter list-group-item">
    <a href="<?=$chapter['url']?>"  rel="noopener" target="_blank" class="text-dark text-decoration-none fw-semibold d-block">
        Chapter <?=(int)$chapter['number'] == $chapter['number']?(int)$chapter['number']:$chapter['number']?>        
    </a>
    <span class="text-secondary small d-block">
    <?php
    require_once('function.php');
    echo timeElapsedString(new DateTime($chapter['updated_at']));
    ?>
    </span>
</li>