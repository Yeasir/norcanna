<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

    <!-- /.order-pagination-status start -->
    <div class="order-pagination-status text-lg-right text-md-left text-sm-center text-capitalize">
        <ul class="list-inline">
            <li class="list-inline-item pagenation-items mr-5"><p><?php echo $current_page; ?>-<?php echo $customer_orders->max_num_pages; ?> pages</p></li>
            <li class="list-inline-item ml-lg-5 ml-sm-3 ml-0">
                <div class="delivered-processed">
                    <a href="#" class="btn orange all active" data-com-pro="all">all</a>
                    <a href="#" class="btn orange delivered" data-com-pro="completed">Delivered</a>
                    <a href="#" class="btn orange processed" data-com-pro="processing">Processed</a>
                </div>
            </li>
        </ul>
    </div>
    <!-- /.order-pagination-status end -->

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order" data-order-event="<?php echo esc_attr( $order->get_status() ); ?>">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) {
										echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

    <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination" style="margin-top: 30px">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-Button--previous woocommerce-button button view" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-Button--next woocommerce-button button view" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else :

    $recommededThreeProduct = get_field('select_product_1', 'option');
    if( $recommededThreeProduct ) {
        ?>
        <!-- /.no-order-yet start -->
        <div class="no-order-yet text-capitalize mb-5">
            <h4>no order yet</h4>
            <h3>Let us Recommend</h3>
            <?php
            foreach ($recommededThreeProduct as $proItem) {
                $product = wc_get_product($proItem);
                ?>

                <!-- /.recommended-items start -->
                <div class="mt-4 recommended-items d-lg-flex d-md-flex  d-sm-flex d-block align-items-md-center">
                    <div class="recommended-thumb">
                        <a href="<?php echo $product->get_permalink(); ?>">
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail'); ?>
                            <img src="<?php echo $image[0]; ?>" class="img-fluid" alt=""/>
                        </a>
                    </div>
                    <div class="recommended-title-price ml-3">
                        <h5><a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a>
                        </h5>
                        <p><?php echo $product->get_price_html(); ?></p>
                    </div>
                    <div class="recommended-btn ml-lg-auto ml-md-auto ml-0 text-left text-lg-right text-sm-right">
                        <a href="<?php echo $product->get_permalink(); ?>" class="btn orange learn-more-btn">learn
                            more</a>

                        <a href="<?php echo $product->add_to_cart_url();?>" data-quantity="1"
                           class="btn orange ml-lg-5 ml-0 product_type_<?php echo $product->get_type();?> add_to_cart_button ajax_add_to_cart"
                           data-product_id="<?php echo $product->get_id();?>" data-product_sku="" aria-label="Add “Product” to your cart"
                           rel="nofollow"> Add to cart</a>
                    </div>
                </div>
                <!-- /.recommended-items end -->
                <?php
            }
            ?>
        </div>
        <!-- /.no-order-yet end -->
        <?php
    }

endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
