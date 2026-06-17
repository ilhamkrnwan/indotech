<?php
/**
 * Partnership program card.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id    = get_the_ID();
$badge      = dc_get_partnership_meta( $post_id, '_partnership_badge' );
$location   = dc_get_partnership_location( $post_id );
$summary    = dc_get_partnership_summary( $post_id );
$services   = array_slice( dc_parse_lines( dc_get_partnership_meta( $post_id, '_partnership_services' ) ), 0, 3 );
$type_label = dc_get_partnership_types_label( $post_id );
?>

<article <?php post_class( 'bg-white p-3 md:p-6 dc-card-custom border border-outline-variant/30 hover:border-secondary transition-all group flex flex-col justify-between h-full' ); ?>>
    <a href="<?php the_permalink(); ?>" class="block">
        <div class="aspect-[16/10] bg-surface-container-low dc-card-media-custom mb-3 md:mb-4 flex items-center justify-center relative overflow-hidden">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', [ 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300', 'loading' => 'lazy' ] ); ?>
            <?php else : ?>
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-secondary/5 to-secondary/15">
                    <?php echo dc_icon( 'store', 'w-10 h-10 md:w-14 md:h-14 text-secondary/30' ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( $badge ) : ?>
                <div class="absolute top-2 right-2 bg-primary-container text-on-primary-container text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    <?php echo esc_html( $badge ); ?>
                </div>
            <?php endif; ?>
        </div>
    </a>

    <div class="space-y-3 flex-1 flex flex-col justify-between">
        <div class="space-y-2">
            <div class="flex justify-between items-center mb-1">
                <span class="text-[11px] md:text-xs font-bold text-on-surface-variant flex items-center gap-1">
                    <?php if ( $type_label ) : ?>
                        <span class="px-2 py-0.5 bg-surface-container rounded-full text-[10px] uppercase tracking-wider font-extrabold text-secondary"><?php echo esc_html( $type_label ); ?></span>
                    <?php endif; ?>
                </span>
                <?php if ( $location ) : ?>
                    <div class="flex items-center text-secondary gap-1">
                        <?php echo dc_icon( 'map-pin', 'w-3.5 h-3.5 text-secondary' ); ?>
                        <span class="text-[11px] md:text-xs font-bold text-on-surface-variant"><?php echo esc_html( $location ); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <h4 class="text-sm md:text-lg font-bold text-on-surface group-hover:text-secondary transition-colors line-clamp-1">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
            
            <?php if ( $summary ) : ?>
                <p class="text-xs md:text-sm text-on-surface-variant line-clamp-2"><?php echo esc_html( $summary ); ?></p>
            <?php endif; ?>

            <?php if ( $services ) : ?>
                <ul class="text-[11px] md:text-xs text-on-surface-variant space-y-1.5 pt-2">
                    <?php foreach ( $services as $service ) : ?>
                        <li class="flex items-center gap-1.5">
                            <?php echo dc_icon( 'check-circle', 'w-3.5 h-3.5 text-accent-dark flex-shrink-0' ); ?>
                            <span class="line-clamp-1"><?php echo esc_html( $service ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 pt-3 md:pt-4 border-t border-outline-variant/30 mt-3 md:mt-4">
            <a class="w-full sm:flex-1 text-center py-2 px-2.5 bg-secondary text-white text-[11px] md:text-xs font-bold rounded-lg hover:bg-secondary/90 transition-all flex items-center justify-center gap-1" href="<?php the_permalink(); ?>">
                <span><?php esc_html_e( 'Detail', 'depocleanique-custom' ); ?></span>
                <?php echo dc_icon( 'arrow-right', 'w-3 h-3 text-white' ); ?>
            </a>
            <a class="w-full sm:flex-1 text-center py-2 px-2.5 border border-outline text-on-surface text-[11px] md:text-xs font-bold rounded-lg hover:bg-surface-container-low transition-all flex items-center justify-center gap-1" href="<?php echo esc_url( dc_get_partnership_whatsapp_url( $post_id ) ); ?>" target="_blank" rel="noopener noreferrer">
                <?php echo dc_icon( 'message-circle', 'w-3 h-3 text-on-surface' ); ?>
                <span><?php esc_html_e( 'Konsultasi', 'depocleanique-custom' ); ?></span>
            </a>
        </div>
    </div>
</article>
