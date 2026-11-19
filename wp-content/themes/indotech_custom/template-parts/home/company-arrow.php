<?php
/** Decorative navigation icon. */
$direction = $args['direction'] ?? 'right';
?>
<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
    <?php if ( $direction === 'down' ) : ?>
        <path d="M12 4v15m-6-6 6 6 6-6"/>
    <?php else : ?>
        <path d="M5 12h14m-6-6 6 6-6 6"/>
    <?php endif; ?>
</svg>
