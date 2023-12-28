<nav aria-label="...">
    <ul class="pagination">
        <li class="page-item <?php echo $previous_page ? '' : 'disabled'; ?>">
            <?php if ($previous_page): ?>
            <a class="page-link" href="<?php echo $previous_page; ?>">Previous</a>
            <?php else: ?>
            <span class="page-link">Previous</span>
            <?php endif; ?>
        </li>
        <?php foreach ($pages as $page): ?>
        <li class="page-item <?php echo $page['active'] ? 'active' : ''; ?>"
            <?php echo $page['active'] ? 'aria-current="page"' : ''; ?>>
            <?php if ($page['active']): ?>
            <span class="page-link"><?php echo $page['number']; ?></span>
            <?php else: ?>
            <a class="page-link" href="<?php echo $page['url']; ?>"><?php echo $page['number']; ?></a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <li class="page-item <?php echo $next_page ? '' : 'disabled'; ?>">
            <?php if ($next_page): ?>
            <a class="page-link" href="<?php echo $next_page; ?>">Next</a>
            <?php else: ?>
            <span class="page-link">Next</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>