<?php
include_once("db_connect.php");
$post = $total_call = $call_records = array();
$total_call_sql = $call_sql = $where_condition = "";
$post = $_REQUEST;
$limit = $post["rowCount"];


// handling pagination
if (isset($post["current"])) { 
	$page = $post["current"]; 
} else { 
	$page = 1; 
}  
$start = ($page-1) * $limit;

//dropdown first for city then query table for that city
//311data as variable for query
//table for city names -- inner join between names and table
//311data {miami, austin}




// handling search
if(!empty($post['searchPhrase'])) {   
	$where_condition .=" WHERE ";
	$where_condition .=" ( issue_type LIKE '".$post['searchPhrase']."%' ";    
	$where_condition .=" OR city LIKE '".$post['searchPhrase']."%' ";
	$where_condition .=" OR ticket_year LIKE '".$post['searchPhrase']."%' ";
	$where_condition .=" OR zip_code LIKE '".$post['searchPhrase']."%' ";
	$where_condition .=" OR neighborhood_district LIKE '".$post['searchPhrase']."%' ";
	$where_condition .=" OR case_owner LIKE '".$post['searchPhrase']."%' )";
}
// handling sorting
if( !empty($post['sort']) ) {  
	$where_condition .=" ORDER By ".key($post['sort']) .' '.current($post['sort'])." ";
}
$sql_query = "SELECT ticket_id as call_ticketId, issue_type as call_issueType, city as call_city, ticket_year as call_year, zip_code as call_zip, neighborhood_district as call_dist, case_owner as call_case_owner,
street_address as call_street_address, state as call_state, created_year_month as call_year_month, ticket_status as call_ticket_status FROM `miami` ";

$total_call_sql .= $sql_query;
$call_sql .= $sql_query;
if(isset($where_condition) && $where_condition != '') {
	$total_call_sql .= $where_condition;
	$call_sql .= $where_condition;
}


// handling limit to get data 
if ($limit!=-1) {
	$call_sql .= "LIMIT $start, $limit";
}
// Getting total number of call record count
$result_total = mysqli_query($conn, $total_call_sql) or die("database error:". mysqli_error($conn));
$total_call = mysqli_num_rows($result_total);

// getting call records and store into an array
$resultset = mysqli_query($conn, $call_sql) or die("database error:". mysqli_error($conn));
while( $call = mysqli_fetch_assoc($resultset) ) { 
	$call_records[] = $call;       
}
// creating call data array according to jQuery Bootgrid requirement to display records
$call_json_data = array(
	"current"   => intval($post['current']), 
	'rowCount'  => 10,
	"total"     => intval($total_call),
	"rows"      => $call_records 
);
// return call data array as JSON data
echo json_encode($call_json_data);