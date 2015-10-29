<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $road_opt, $road_productrows, $road_productsfound, $road_viewmode;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}

$count   = $product->get_rating_count();

$colwidth = round(12/$woocommerce_loop['columns']);

$classes[] = ' item-col col-xs-12 col-sm-'.$colwidth ;?>

<?php if ( ( 0 == ( $woocommerce_loop['loop'] - 1 ) % 2 ) && ( $woocommerce_loop['columns'] == 2 ) ) {
	if($road_productrows!=1){
		echo '<div class="group">';
	}
} ?>

<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<?php if ( $product->is_on_sale() ) : ?>
			<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'allen' ) . '</span></span>', $post, $product ); ?>
		<?php endif; ?>
		<div class="list-col4 <?php if($road_viewmode=='list-view'){ echo ' col-xs-12 col-sm-4';} ?>">
			<div class="product-image">
				<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
					<?php 
					echo wp_kses($product->get_image('shop_catalog', array('class'=>'primary_image')), array(
						'a'=>array(
							'href'=>array(),
							'title'=>array(),
							'class'=>array(),
						),
						'img'=>array(
							'src'=>array(),
							'height'=>array(),
							'width'=>array(),
							'class'=>array(),
							'alt'=>array(),
						)
					));
					
					if(isset($road_opt['second_image'])){
						if($road_opt['second_image']){
							$attachment_ids = $product->get_gallery_attachment_ids();
							if ( $attachment_ids ) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
					<span class="shadow"></span>
				</a>
				<div class="quickview2">
					<div class="quickviewbtn">
						<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'allen');?></a>
					</div>
				</div>
				<div class="actions2">
					<div class="action-buttons">
						<div class="quickviewbtn">
							<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'allen');?></a>
						</div>
						<div class="add-to-links">
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
								echo do_shortcode('[yith_compare_button]');
							} ?>
						</div>
					</div>
					<div class="add-to-cart">
						<?php echo do_shortcode('[add_to_cart id="'.$product->id.'"]') ?>
					</div>
				</div>
				<div class="actions">
					<div class="ratings"><?php echo ''.$product->get_rating_html(); ?></div>
					<div class="action-buttons">
						<div class="add-to-cart">
							<?php echo do_shortcode('[add_to_cart id="'.$product->id.'"]') ?>
						</div>
						<div class="add-to-links">
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
								echo do_shortcode('[yith_compare_button]');
							} ?>
						</div>
						<div class="quickviewbtn">
							<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'allen');?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="list-col8 <?php if($road_viewmode=='list-view'){ echo ' col-xs-12 col-sm-8';} ?>">
			<div class="gridview">
				<h2 class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php //do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
<?php if ( ( ( 0 == $woocommerce_loop['loop'] % 2 || $road_productsfound == $woocommerce_loop['loop'] ) && $woocommerce_loop['columns'] == 2 )  ) { /* for odd case: $road_productsfound == $woocommerce_loop['loop'] */
	if($road_productrows!=1){
		echo '</div>';
	}
} ?>