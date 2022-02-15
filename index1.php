<html>   
  <head>   
    <title>Pagination</title>   
    <link rel="stylesheet"  
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">   
    <link rel="stylesheet" href="main.css">
  </head>   
  <body>   
      
  <center>  
    <?php  
    // Import the file where we defined the connection to Database.     
        require_once "conn.php";   
        $per_page_record = 10;  // Number of entries to show in a page.   
        // Look for a GET variable page if not found default is 1.        
        if (isset($_GET["page"])) {    
            $page  = $_GET["page"];    
        }    
        else {    
          $page=1;    
        }    
    
        $start_from = ($page-1) * $per_page_record;     
        $query = "SELECT * FROM mock_data LIMIT $start_from, $per_page_record";     
        $rs_result = mysqli_query ($conn, $query);    
    ?>    
  
    <div class="container">   
      <br>   
      <div>   
        <h1> Create a Custom Pagination  </h1>   
       <form>
           <button  type="Submit", class="button btn btn-primary">Search</button>
          <input type="text", name="search" placeholder="Search data" value= "<?php if(isset($_GET['search'])) {echo$_GET['search'];} ?>"required/>
      </form> 
  <?php
    if(isset($_GET['search']))
    {
        $filtervalues=$_GET['search'];
        $query="SELECT*FROM mock_data WHERE CONCAT(full_name,email)LIKE '%$filtervalues%' ";
        $query_run=mysqli_query($conn,$query);

        if(mysqli_num_rows($query_run)>0)
        {
            foreach($query_run as $items)
            {
                ?>
                <table>
                  <tr>
                      <td><?php=$items['id'];?></td>
                      <td><?php=$items['full_name'];?></td>
                      <td><?php=$items['email'];?></td>
                  </tr>
                  </table>

                <?php
            }

        }
        else
        {
            ?>
            <tr>
            <td  colspan="3">Not Found this Record.</td>
            </tr>
            <?php
        }
    }
?>
  

        <table class="table table-striped table-condensed table-bordered">   
          <thead>   
            <tr>   
              <th width="10%">ID</th>   
              <th>Full Name</th>   
              <th>Email</th>   
          
            </tr>   
          </thead>   
          <tbody>   
    <?php     
            while ($row = mysqli_fetch_array($rs_result)) {    
                  // Display each field of the records.    
            ?>     
            <tr>     
             <td><?php echo $row["id"]; ?></td>     
            <td><?php echo $row["full_name"]; ?></td>   
            <td><?php echo $row["email"]; ?></td>   
                                                 
            </tr>     
            <?php     
                };    
            ?>     
          </tbody>   
        </table>   
  
     <div class="pagination">    
      <?php  
        $query = "SELECT COUNT(*) FROM mock_data";     
        $rs_result = mysqli_query($conn, $query);     
        $row = mysqli_fetch_row($rs_result);     
        $total_records = $row[0];     
          
    echo "</br>";     
        // Number of pages required.   
        $total_pages = ceil($total_records / $per_page_record);     
        $pagLink = "";       
      
        if($page>=2){   
            echo "<a href='index1.php?page=".($page-1)."'>  Prev </a>";   
        }       
                   
        for ($i=1; $i<=$total_pages; $i++) {   
          if ($i == $page) {   
              $pagLink .= "<a class = 'active' href='index1.php?page=" .$i."'>".$i." </a>";   
          }               
          else  {   
              $pagLink .= "<a href='index1.php?page=".$i."'> ".$i." </a>";     
          }   
        };     
        echo $pagLink;   
  
        if($page<$total_pages){   
            echo "<a href='index1.php?page=".($page+1)."'>  Next </a>";   
        }   
  
      ?>    
      </div>  
  
  
      <div class="inline">   
      <input id="page" type="number" min="1" max="<?php echo $total_pages?>"   
      placeholder="<?php echo $page."/".$total_pages; ?>" required>   
      <button onClick="go2Page();">Go</button>   
     </div>    
    </div>   
  </div>  
</center>   
  <script>   
    function go2Page()   
    {   
        var page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = 'index1.php?page='+page;   
    }   
  </script>  
  </body>   
</html>  