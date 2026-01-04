<!-- Pagination (Navigasi Halaman) -->
<?php if ($totalPages > 1): ?>
<div class="paginations">
    <ul class="lab-ul d-flex flex-wrap justify-content-center mb-1">
        <?php if ($page > 1): ?>
        <li>
            <a href="?page=<?php echo $page - 1; ?>"><i class="icofont-rounded-double-left"></i></a>
        </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <li>
            <a href="?page=<?php echo $page + 1; ?>"><i class="icofont-rounded-double-right"></i></a>
        </li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
