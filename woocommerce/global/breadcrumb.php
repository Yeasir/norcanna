<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}*/
?>
<section class="breadcrumb-filter">
    <div class="container">
        <div class="row">
            <div class="col-md-4 breadcrumb-wrap">
                <ol class="">
                    <li><a href="#">Home</a></li>
                    <li class="sep"><i class="fa fa-angle-right">&nbsp;</i></li>
                    <li class="active">Categories</li>
                </ol>
            </div>
            <div class="col-md-8">
                <div class="pfilter_wrap clearfix">
                    <div class=" filter_view  pull-right">
                        <ul class="list-inline">
                            <li class="list-inline-item active"><a href="#"><i class="fa fa-th">&nbsp;</i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-list">&nbsp;</i></a></li>
                        </ul>
                    </div>
                    <div class="filter_sort_by  pull-right">
                        <select class="product-filter-select">
                            <option>Popularity</option>
                            <option>Price</option>
                            <option>Name</option>
                            <option>Latest</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Breadcrumb Filter  -->
