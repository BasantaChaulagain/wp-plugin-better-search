<?php

//include fake_wp
include "fake_wp.php";

//include target function
include "./better-search-replace/better-search-replace.php";

//triger target function
// creates an object of class Better_Search_Replace and runs it. Initializing function
run_better_search_replace();

$bsr_db = new BSR_DB();
$page = 0;
// get all tables in the database wpdb
$tables = $bsr_db->get_tables();

//user input data
$_POST['bsr_data']="search_for=test&replace_with=rest&total_pages=10";

$args = array();
parse_str( $_POST['bsr_data'], $args );
// var_dump($args);
// Build the arguements for this run.
$args = array(
    'select_tables' 	=> isset( $args['select_tables'] ) ? $args['select_tables'] : array(),
    'case_insensitive' 	=> isset( $args['case_insensitive'] ) ? $args['case_insensitive'] : 'off',
    'replace_guids' 	=> isset( $args['replace_guids'] ) ? $args['replace_guids'] : 'off',
    'dry_run' 			=> isset( $args['dry_run'] ) ? $args['dry_run'] : 'off',
    'search_for' 		=> isset( $args['search_for'] ) ? stripslashes( $args['search_for'] ) : '',
    'replace_with' 		=> isset( $args['replace_with'] ) ? stripslashes( $args['replace_with'] ) : '',
    'completed_pages' 	=> isset( $args['completed_pages'] ) ? absint( $args['completed_pages'] ) : 0,
);
// $args['total_pages'] = isset( $args['total_pages'] ) ? absint( $args['total_pages'] ) : $db->get_total_pages( $args['select_tables'] );

//search for text in all and replace.
foreach ($tables as $table){
    $bsr_db -> srdb($table, $page, $args);
}