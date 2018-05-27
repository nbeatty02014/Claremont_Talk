<?php
    include('dbconn.php');
    session_start();
?>


<!--TODO: Sort by Message ID?-->

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel = "stylesheet" type = "text/css" href = "CTalkStyle.css" />
    <meta charset="utf-8" />
    <title>Pageable Displays</title>
    <style>
    body{
    margin-top: 30px;
    margin-bottom: 30px;
    margin-right: 50px;
    margin-left: 50px;
    font-family: "arial";
     background-color:  #d7dfe0;
    }
        h1{
    text-align: center;
color: black;
background-size: 100%;
background-color:  #ccf6ff;
color: dodgerblue;
     text-shadow: 1px 1px 0px #9fb3b5; /* FF3.5+, Opera 9+, Saf1+, Chrome, IE10 */
}
th{ 
    border: 1px solid;
    background-color: #3cc453;
}

        tr:nth-child(even) {
            background-color: #9fb3b5;
        }
table{ 
margin-left: auto;
margin-right: auto;
height:95%;width:100%; 
}
  h1{
  text-align: center;
color: black;
background-size: 100%;
background-color:  #d7dfe0;
color: dodgerblue;
     text-shadow: 1px 1px 0px #9fb3b5; /* FF3.5+, Opera 9+, Saf1+, Chrome, IE10 */
}
span{
    text-align: left;
    border: ;
    background-size: 100%;
    background-color:  ;
    color: black;
    font-size: 20px;
  }
td:hover {background-color: white;}
 .nav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

.navigation {
    float: left;
}
.navigation a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.navigation a:hover {
    background-color: dodgerblue;
}
.title {
    width:150px;
}
.name{
    width:150px;
}
.type{
    width:150px;
}
.date{
    width:150px;
}
}
/*.messageContents{
   
}*/
.approve{
    width:75px;
}    
.messageID{
    width:75px;
}   
.delete{
    width:75px;
} 

</style>
        
</head>
    
<body style="background-color: #ccf6ff">
</h1> 


<?php
    
    // TODO:
    // verify admin
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        if(isset($_POST['approved'])){

            $connection = connect_to_db("ClaremontTalk");

            foreach ($_POST['approved'] as $key => $messageID){
            
                $query = "UPDATE Messages SET approved = 1 WHERE messageID = '$messageID'";
                $result = perform_query($connection, $query);


                $qry = "SELECT userId  as 'a' FROM Messages WHERE messageID = '$messageID'";
                $user = perform_query($connection, $qry)->fetch_object()->a;;
                echo $user;

                $query = "SELECT email  as 'a' FROM User WHERE userId = '$user'";
                $email = perform_query($connection, $query)->fetch_object()->a;
                echo $email;

                $to = $email;
                $subject = "Message Approved";
                $txt = $message = "Your message has been approved.";
                $headers = "From: claremont@talk.com";
                mail($to,$subject,$txt,$headers);

                // $query = "UPDATE Messages SET emailed = 0 WHERE messageID = '$messageID'";
                // $result = perform_query($connection, $query);


            }
            disconnect_from_db($connection, $result);

        }

        header('Location: sendEmails.php');
        
    }



    // pagination support
    $itemsPerPage=10;
    // figure out how many pages
    $pages = findpages($itemsPerPage);
    $start = findstart();
        
    $links = createSortLinks();
    createDataTable($start, $itemsPerPage, $links);
    createPageLinks($start, $pages, $itemsPerPage, $links['orderby']);
?>

</body>
</html>


<?php
function createDataTable($start, $itemsPerPage, $links) {
    $qry = "SELECT title, name, messageContents, type, dt, messageID FROM Messages 
                WHERE approved = 0 
                ORDER BY {$links['orderby']}
                LIMIT $start, $itemsPerPage ";

        
    echo  "<h1 style = 'background-color: #ccf6ff'>ClaremontTalk</h1> 
    <ul class='nav'> 
  <li class='navigation'><a href='viewMessages.php'>View Message Board</a></li>
  <li class='navigation'><a href='message.php'>Create Message</a></li>
   <li class='navigation'><a href='index.php'>Logout</a></li>
</ul>
        <form method = 'post' action='approveMessages.php'>
            <table class=\"fixed\">
                    <tr>
                        <th class=\"title\"> <a href={$links['title']}> Title</a></th>
                        <th class=\"name\"><a href={$links['name']}>Name</a></th>
                        <th class=\"messageContents\"><a href={$links['message']}>Message</a></th>
                        <th class=\"type\"><a href={$links['type']}>Type</a></th>
                        <th class=\"messageID\"><a href={$links['messageID']}>Message ID</a></th>
                         
                        <th class=\"date\"><a href={$links['date']}>Date Sent</a></th>
                        <th class=\"approve\">Approve</th>
                        <th class=\"delete\">Delete</th>
                    </tr> \n ";
                    //<th class=\"photo\"><a href={$links['photo']}>Photo</a></th>


        $dbc =  connect_to_db("ClaremontTalk");
        $result = perform_query($dbc, $qry);
        $class = "alt2";
        while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
            $class = ($class=='alt1' ? 'alt2':'alt1');
            echo "  <tr class=\"$class\">
                        <td>$title</td>
                        <td>$name</td>
                        <td>$messageContents</td>
                        <td>$type</td>
                        <td>$messageID</td>
                        <td>$dt</td>
                        
                        <td><input type='checkbox' name='approved[]' value=$messageID></td>
                        <td><input type='checkbox' name='delete[]' value=$messageID></td>

                    </tr>\n";
                    //<td>$photo</td>
        }

        echo "</table>
                <br/>
                <span>APPROVE, DELETE, AND EMAIL: </span><input type='submit' value='Go'>
            </form>\n
            <br/>
            <button type = 'button' class='button' onclick='window.location.href=\"viewMessages.php\"'>Exit</button>";
    }



function findpages($itemsPerPage){
    if (isset($_GET['p'])){
        // get it from the URL if we've already been here
        $pages=$_GET['p'];
    } else {
    
        // starting new, so get it from the database
        $qry="SELECT COUNT(messageId) as count from Messages where approved = 0;";
        
        $dbc =  connect_to_db( "ClaremontTalk" );
        $result = perform_query($dbc, $qry);
        extract((array)mysqli_fetch_array($result, MYSQLI_ASSOC));
            
        if ($count > $itemsPerPage)
            $pages=ceil($count/$itemsPerPage);
        else
            $pages=1;
    }
    return $pages;
}


function findstart(){
    // figure out where to start
    if (isset($_GET['s']))
        $start=$_GET['s'];
    else
        $start=0; // at the beginning
        
    return($start);
}

function createSortLinks(){
    $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameA";  
    //echo  $namelink."<br>";
    $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeA"; 
    //echo $typeLink."<br>";
    $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageA"; 
    //echo $messageLink."<br>";
    $photoLink = "{$_SERVER['PHP_SELF']}?sort=photoA";  
    //echo  $photoLink."<br>";
    $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleA";
    //echo  $titleLink."<br>";
    $orderby="name ASC";
    $sort = isset($_GET['sort']) ? $_GET['sort']: "nameA" ;

    switch ($sort){
        case 'nameA':
            $orderby='name ASC';
            $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameD";
            break;  

        case 'nameD':
            $orderby='name DESC';
            $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameA";
            break;

        case 'titleA':
            $orderby='title ASC';
            $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleD";
            break;

        case 'titleD':
            $orderby='title DESC';
            $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleA";
            break;
        

        case 'messageA':
            $orderby='messageContents ASC';
            $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageD";
            break;
        
        case 'messageD':
            $orderby='messageContents DESC';
            $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageA";
            break;


        // case 'photoA':
        //     $orderby='photo ASC';
        //     $photoLink = "{$_SERVER['PHP_SELF']}?sort=messageD";
        //     break;
        
        // case 'photoD':
        //     $orderby='photo DESC';
        //     $photoLink = "{$_SERVER['PHP_SELF']}?sort=messageA";
        //     break;

        case 'typeA':
            $orderby='type ASC';
            $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeD";
            break;
    
        case 'typeD':
            $orderby='type DESC';
            $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeA";
            break;              
        default:
            break;
    }


 
    
    //echo    $orderby."<br>";
    //echo $_GET['sort']."<br>";
    //echo $sort;
    $links = array("name"=> $nameLink, "type"=> $typeLink, "photo"=> $photoLink, "message"=> $messageLink, "title"=> $titleLink, "orderby" => $orderby);




    return $links;
}


function createPageLinks($start, $pages, $itemsPerPage, $sort){
    $thispage = "{$_SERVER['PHP_SELF']}";
    $sort = isset($_GET['sort']) ? $_GET['sort']: "";
    //echo "This page is $thispage";
    
    
    // creating page links
    if ($pages > 1) {
        echo '<br /><hr />';
        
        // print Previous if not on the first page
        $currentPage=($start/$itemsPerPage) + 1;
        if ($currentPage != 1){
            echo '<a href="'.$thispage.'?s='.($start - $itemsPerPage) . 
                                        '&amp;p=' . $pages . 
                                        '&amp;sort=' . $sort .
                                        '"> Previous </a>';
        }
        
        // print page numbers
        for ($i=1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="'.$thispage.'?s='.(($itemsPerPage * ($i-1))) . 
                                                '&amp;p=' . $pages . 
                                                '&amp;sort=' . $sort .
                                                '"> '. $i .'  </a>'."\n";
                }  else {
                    echo $i . ' ';
                }
        }
    
        // print next if not on the last page
        if ($currentPage != $pages){
            echo '<a href="'.$thispage.'?s='.($start + $itemsPerPage) . '&amp;p=' . 
                                                $pages . '"> Next </a>';
        }
    }
}
?>
