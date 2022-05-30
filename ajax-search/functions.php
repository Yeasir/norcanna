<?php
//Add Ajax Actions
function advance_search(){
    echo  "search is here";
}

add_action( 'wp_ajax_advance_search', 'advance_search' );
add_action( 'wp_ajax_nopriv_advance_search', 'advance_search' );