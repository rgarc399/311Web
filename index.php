<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body class="">


<div style="margin-bottom: 0px;" role="navigation" class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">311 Data</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a >Home</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


<div class="wrapper">

  <!-- Sidebar Holder -->
  <div id="sidebar">
    <div class="sidebar-header">
      <h3>Filters</h3>
    </div>


    <ul class="list-unstyled components">
      <p>Select City</p>
      <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Cities</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
        <?php
            include_once("db_connect.php");
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT city_name FROM cities";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                echo "<li><a href='#' onclick='filterByCity(this)' name=" . $row["city_name"] . ">". $row["city_name"] ."</a></li>";
              }
            } 
            else {
            
            }
            $conn->close();
            ?>
            
        </ul>
      </li>
    </ul>
    
    <ul class="list-unstyled components">
    <p>By Year City Data </p>
      <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">City Years</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
        
        </ul>
      </li>
    </ul>
      

 
    
    
    

   

</div>

  <!-- Page Content Holder -->
  <div id="content">
          <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span>Toggle Sidebar</span>
                            </button>
    </div>
    <div class="container" style="min-height:500px;">

    <title>311 Data : Filter and Search through 311 Data</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>  

<div class="container">	
	<h2>Filter and Search through 311 Data</h2>	
	<br>
	<br>	
	<table id="calls" data-toggle="bootgrid" class="table table-condensed table-hover table-striped" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th data-column-id="call_ticketId" data-type="numeric">Ticket ID</th>
				<th data-column-id="call_issueType">Issue Type</th>
				<th data-column-id="call_city">City</th>
				<th data-column-id="call_year">Year</th>
				<th data-column-id="call_zip">Zip Code</th>
				<th data-column-id="call_dist">District</th>
				<th data-column-id="call_case_owner">Case Owner</th>
        <th data-column-id="call_street_address">Street Address</th>
				<th data-column-id="call_state">State</th>
        <th data-column-id="call_year_month">Created Year Month</th>
        <th data-column-id="call_ticket_status">Ticket Status</th>
			</tr>
		</thead>
	</table>	
	<div style="margin:50px 0px 0px 0px;">
	</div>
	
</div>

    </div>



    <script>

// DROP DOWN MENU
            function filterByCity(city){
            var formData = new FormData();
            formData.append('tableName', city.name);
            console.log(formData.get('tableName'));

      $("#calls").bootgrid({
                ajax: true,
		            url: "search.php",
                data: formData,
                type: "POST",
                cache: false,
                post: function(data){
                  
                  return{
                    tableName: city.name,
                  };
                }
            });
            }


// SIDEBAR
      $(document).ready(function() {
//         $("#calls").bootgrid({	
//           ajax: true,	
//           url: "fetch_data.php"	
//         });
        $("#sidebarCollapse").on("click", function() {
          $("#sidebar").toggleClass("active");
          $(this).toggleClass("active");
        });
});


    </script>

</div>
  </body>
</html>
    