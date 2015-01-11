<?php

include_once 'includes/connect.php';
include_once 'includes/functions.php';
include_once 'includes/jpgraph/jpgraph.php';
include_once 'includes/jpgraph/jpgraph_bar.php';

sec_session_start();
	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies Inventory: Results</title>
		
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
        <link type="text/css" href="css/custom-theme/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
    </head>
    <body>
        
<!-- facebook SDK -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '618900464904792',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
FB.ui({
  method: 'feed',
  link: 'http://developers.facebook.com/docs/', // these parameters overwritten in link below
  picture: 'http://www.studentleadershipcompetencies.com/SLCinfographic.png',
  caption: 'An example caption',
}, function(response){});

</script>
<!-- end facebook SDK -->       

        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
            <div id="wrap">
            <p>Return to <a href="quizhome.php">Dashboard</a></p>           
               

            <?php
            if (login_check($mysqli) == true):
                ?><p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                <a href='#share'>Share your results</a> <!-- ehhh super ugly -->

                <br />

               
<?php

if ($mysqli->connect_errno > 0) {
    die('Unable to connect to database [' . $mysqli->connect_error . ']');
}
$listQuestions = $mysqli->query("SELECT DISTINCT Question FROM Questions");
$numQuestions  = mysqli_num_rows($listQuestions);
$listUniqueCompetencies = $mysqli->query("SELECT DISTINCT Competency FROM Questions");
$numUniqueCompetencies = mysqli_num_rows($listUniqueCompetencies);
$listUniqueCategories = $mysqli->query("SELECT DISTINCT Category FROM Questions");
$numUniqueCategories = mysqli_num_rows($listUniqueCategories);
function mysqli_result($res, $row, $field = 0){ //same function as mysql_result()
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
}
$user = $_SESSION['username']; 

// does he have previousResponses?
$stmt = $dbo->query("SELECT `previousResponsesJSON` FROM members WHERE `username`='$user'");
$results1 = $stmt->fetchColumn(0);
if ($results1 == null){
    $hasPreviousResponses = false;
}else{
    $hasPreviousResponses = true; 
}

// has he taken the quiz yet?
$stmt = $dbo->query("SELECT `responsesJSON` FROM members WHERE `username`='$user'");
$results = $stmt->fetchColumn(0);
if ($results == null){
    $hasResponses = false;
}else{
    $hasResponses = true; 
}

// if 1 or 0 responses, use CSS:singlebox; 2 responses use CSS:box to make graphs side by side
// if there is responses and previousResponses will be built because of incoming POST quiz data,
if ($hasResponses == true && $_SESSION['post_id'] != $_POST['post_id'] && (!empty($_POST))){
    echo '<div class="box">';
// if there is both datas already
}else if($hasResponses == true && $hasPreviousResponses == true){ 
    echo '<div class="box">';
// else 
}else{
    echo '<div class="singlebox">';
}
 
//// Parse responses and send to database or get from database, updating or retrieving previous responses if available 
if( ($_SESSION['post_id'] != $_POST['post_id']) && (!empty($_POST)) ){ // if they came from quiz.php (took the quiz) and prevents resubmission
        $_SESSION['post_id'] = $_POST['post_id']; // locks out now
        if ($hasResponses == false){ 
            // first time taking quiz
            
            unset($_POST['post_id']); // don't want to send this data
            $responses = $_POST; // put all individual responses into database in JSON format (associative array = question# -> #1-5); 
            $responses = array_filter(array_merge(array(0), $responses)); // starts index at 1
            $responses = json_encode((object)$responses);
            $sql = $dbo->prepare("UPDATE members SET responsesJSON ='$responses' WHERE `username`='$user'");
            $sql->execute();
            $t=time();
            $timestamp = date("Y-m-d",$t); // formatted like "2014-12-21";
            $sql = $dbo->prepare("UPDATE members SET timestamp ='$timestamp' WHERE `username`='$user'");
            $sql->execute();
            $responses = json_decode($responses, true); // decode so we can use it for parsing results

        }else{ 
            // not first time taking quiz
            // DATABASE: columns responsesJSON[  ] and previousResponsesJSON[  ] is altered by
            // a makeshift queue data structure: POST -> [responses] -> [previousResponses] -> //garbage collected
            
            $stmt = $dbo->query("SELECT `responsesJSON` FROM members WHERE `username`='$user'");
            $responses = $stmt->fetchColumn(0); 
            $previousResponses = $responses; 
            $sql = $dbo->prepare("UPDATE members SET previousResponsesJSON ='$responses' WHERE `username`='$user'"); 
            $sql->execute();
            
            $stmt = $dbo->query("SELECT `timestamp` FROM members WHERE `username`='$user'");
            $t = $stmt->fetchColumn(0); 
            $sql = $dbo->prepare("UPDATE members SET previousTimestamp ='$t' WHERE `username`='$user'");
            $sql->execute();

            $responses = null;
            $t = null;
            
            unset($_POST['post_id']);
            $responses = $_POST; 
            $responses = array_filter(array_merge(array(0), $responses));  // starts index at 1
            $responses = json_encode((object)$responses);                  //$responses is POST
            $sql = $dbo->prepare("UPDATE members SET responsesJSON ='$responses' WHERE `username`='$user'");
            $sql->execute();
            $t=time();
            $timestamp = date("Y-m-d",$t); // formatted like "2014-12-21";
            $sql = $dbo->prepare("UPDATE members SET timestamp ='$timestamp' WHERE `username`='$user'");
            $sql->execute();
            // so now the database is [POST] -> [responses]


            $responses = json_decode($responses, true);
            $previousResponses = json_decode($previousResponses, true);
        }
    
}else{ // if they came from quizhome.php or anywhere else, just get the responses from database, no updates
    if ($hasResponses == false){ 
        // if has less than 2 datasets (0 or 1)
        $stmt = $dbo->query("SELECT `responsesJSON` FROM members WHERE `username`='$user'");
        $result = $stmt->fetchColumn(0);
        if ($results != null){ // 1 dataset
            $responses = $result;
            $responses = json_decode($responses, true);
        }else{ // 0 dataset
            echo '<p> You haven\'t taken the quiz yet! </p>';
            echo '<p>Return to <a href="quizhome.php">login page</a></p>';
            exit();
        }
    }else{
        // else has 2 datasets (both responsesJSON and previousResponsesJSON filled)
        $stmt = $dbo->query("SELECT `responsesJSON` FROM members WHERE `username`='$user'");
        $responses = $stmt->fetchColumn(0); 
        $responses = json_decode($responses, true);
        $stmt = $dbo->query("SELECT `previousResponsesJSON` FROM members WHERE `username`='$user'");
        $previousResponses = $stmt->fetchColumn(0);
        $previousResponses = json_decode($previousResponses, true);
    }

}

// end data retrieval/updating

////// calculate scores
//// second, calculate average competency
// $responses
$i = 1;
$scores = array(); // associative array raw scores per competency (competency => score) 
$counts = array(); // count of competency (competency => count)
$averageScores = array(); // associative array averaged scores per competency
$averageScoresToShare = array(); // most recent responses will be shared to FB. Same creation as array above.

// sum scores per competency, increment count per competency
while ($i <= $numQuestions) {
    $dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
    $stmt = $dbo->query("SELECT `Competency` FROM Questions WHERE `id`='$i'"); // notice how Order is a reserved keyword in sql. 
    $current_competency = $stmt->fetchColumn(0);
    $scores[$current_competency] += $responses[$i]; 
    $averageScores[$current_competency]; // initializes keys for averages (I think.)
    $averageScoresToShare[$current_competency];
    $counts[$current_competency] += 1;
    $i++;
}

$xaxisTop = array(); // competency array for graph
$xaxisMiddle = array();
$xaxisBottom = array();
$yaxisTop = array(); // scores array for graph
$yaxisMiddle = array();
$yaxisBottom = array();

// average scores by competency
$stmt = $dbo->query("SELECT `timestamp` FROM members WHERE `username`='$user'");
$responsesTime = $stmt->fetchColumn(0);

echo "<h2> Results from " . $responsesTime . " (most recent): </h2>";
echo "<br />";
foreach($scores as $j => $score){ // $j is the competency string, average scores
    $score = $score / $counts[$j];
    $averageScores[$j] = $score;    
    $averageScoresToShare[$j] = $score;
}
$rankCounter = 0;
arsort($averageScores); // highest to lowest (top to bottom) scores
arsort($averageScoresToShare);

foreach($averageScores as $j => $score){ 
    // echo $j . " " . round($score, 2) . "<br />";
    $rankCounter++;
    if ($rankCounter <= 20){
        array_push($xaxisTop, (string)$j); // really no need to typecast but helps distinguish
        array_push($yaxisTop, (double)round($score, 2));
    }elseif($rankCounter > 20 && $rankCounter <= 40 ){
        array_push($xaxisMiddle, (string)$j);
        array_push($yaxisMiddle, (double)round($score, 2));
    }else{
        array_push($xaxisBottom, (string)$j);
        array_push($yaxisBottom, (double)round($score, 2));
    }
}

// create graphs with data (jpgraph)
include_once 'createjpgraph.php';
generateCompetencyGraphTop($xaxisTop, $yaxisTop); //$competencyArray, $scoreArray
echo '<h2>Top 20 Competencies</h2><br />';
echo '<img src="resultsgraphtop.png" alt="SLC results graph top" class="rotate90" /><br />'; // the graph code
generateCompetencyGraphMiddle($xaxisMiddle, $yaxisMiddle); 
echo '<h2>Middle 20 Competencies</h2><br />';
echo '<img src="resultsgraphmiddle.png" alt="SLC results graph middle" class="rotate90"/><br />';
generateCompetencyGraphBottom($xaxisBottom, $yaxisBottom);
echo '<h2>Lowest 20 Competencies</h2><br />';
echo '<img src="resultsgraphbottom.png" alt="SLC results graph bottom" class="rotate90"/><br />';

// kill variables so we can reuse their names;
$i = null;
$scores = null;
$counts = null;
$averageScores = null;

// Note: pretty much repeating code from here

//// third, calculate average category
$i = 1;
$scores = array(); // associative array scores per category (category => score) 
$counts = array(); // count of category (category => count)
$averageScores = array();

// sum scores per category, increment count per category
while ($i <= $numQuestions) {
    $dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
    $stmt = $dbo->query("SELECT `Category` FROM Questions WHERE `id`='$i'"); // notice how Order is a reserved keyword in sql. 
    $current_category = $stmt->fetchColumn(0);
    $scores[$current_category] += $responses[$i];
    $counts[$current_category] += 1;
    $i++;
}
$xaxisCluster = array(); 
$yaxisCluster = array();
// average scores by category
echo "<h4>Competency Clusters: </h4>";
foreach($scores as $k => $score){ // $k is the category string
    $score = $score / $counts[$k];
    $averageScores[$k] = $score;    
}
arsort($averageScores);
foreach($averageScores as $k => $score){ 
    // echo $k . " " . round($score, 2) . "<br />";
    array_push($xaxisCluster, (string)$k);
    array_push($yaxisCluster, (double)round($score, 2));
}
generateClusterGraph($xaxisCluster, $yaxisCluster); //$competencyArray, $scoreArray
echo '<img src="resultsgraphcluster.png" alt="SLC results graph cluster" class="rotate90" />';
echo '</div>';


//// fourth, same thing here (calculate scores) for previous scores

// if he has previousResponses too, print second set
$stmt = $dbo->query("SELECT `previousResponsesJSON` FROM members WHERE `username`='$user'");
$results2 = $stmt->fetchColumn(0);
if ($results2 == null){
    $hasPreviousResponses = false;
}else{
    $hasPreviousResponses = true; 
}

// $previousResponses
if ($hasResponses == true &&  $hasPreviousResponses == true){ 
        echo '<div class="box">';
        $i = 1;

        $scores = array(); // associative array scores per competency (competency => score) 
        $counts = array(); // count of competency (competency => count)
        $averageScores = array();

        // sum scores per competency, increment count per competency
        while ($i < $numQuestions-1) {
            $dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
            $stmt = $dbo->query("SELECT `Competency` FROM Questions WHERE `id`='$i'"); // notice how Order is a reserved keyword in sql. 
            $current_competency = $stmt->fetchColumn(0);
            $scores[$current_competency] += $previousResponses[$i]; // only changed line is here
            $counts[$current_competency] += 1;
            $i++;
        }
        $xaxisTop2 = array(); // competency array for graph
        $xaxisMiddle2 = array();
        $xaxisBottom2 = array();
        $yaxisTop2 = array(); // scores array for graph
        $yaxisMiddle2 = array();
        $yaxisBottom2 = array();
        // average scores by competency
        $stmt = $dbo->query("SELECT `previousTimestamp` FROM members WHERE `username`='$user'");
        $previousResponsesTime = $stmt->fetchColumn(0);
        echo "<h2>Results from " . $previousResponsesTime . ": </h2>";
        echo "<br />";
        
        /*
        foreach($scores as $j => $score){
            $score = $score / $counts[$j];
            // echo $j . " " . round($score, 2) . "<br />";
            array_push($xaxisPrev, (string)$j);
            array_push($yaxisPrev, (double)round($score, 2));
        }*/
        foreach($scores as $j => $score){ // $j is the competency string
            $score = $score / $counts[$j];
            $averageScores[$j] = $score;    
        }
        $rankCounter = 0;
        arsort($averageScores);
        foreach($averageScores as $j => $score){ 
            // echo $j . " " . round($score, 2) . "<br />";
            $rankCounter++;
            if ($rankCounter <= 20){
                array_push($xaxisTop2, (string)$j); // really no need to typecast but helps distinguish
                array_push($yaxisTop2, (double)round($score, 2));
            }elseif($rankCounter > 20 && $rankCounter <= 40 ){
                array_push($xaxisMiddle2, (string)$j);
                array_push($yaxisMiddle2, (double)round($score, 2));
            }else{
                array_push($xaxisBottom2, (string)$j);
                array_push($yaxisBottom2, (double)round($score, 2));
            }
        }
        
        generateCompetencyGraphTop2($xaxisTop2, $yaxisTop2); //$competencyArray, $scoreArray
        echo '<h2>Top 20 Competencies</h2><br />';
        echo '<img src="resultsgraphtop2.png" alt="SLC results graph top previous" class="rotate90"/><br />'; // the graph code
        generateCompetencyGraphMiddle2($xaxisMiddle2, $yaxisMiddle2); 
        echo '<h2>Middle 20 Competencies</h2><br />';
        echo '<img src="resultsgraphmiddle2.png" alt="SLC results graph middle previous" class="rotate90"/><br />';
        generateCompetencyGraphBottom2($xaxisBottom2, $yaxisBottom2);
        echo '<h2>Lowest 20 Competencies</h2><br />';
        echo '<img src="resultsgraphbottom2.png" alt="SLC results graph bottom previous" class="rotate90"/><br />';

        
        // kill variables so we can reuse their names;
        $i = null;
        $scores = null;
        $counts = null;
        $averageScores = null;


        $i = 1;
        $scores = array(); // associative array scores per category (category => score) 
        $counts = array(); // count of category (category => count)
        $averageScores = array();

        // sum scores per category, increment count per category
        while ($i < $numQuestions-1) {
            $dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
            $stmt = $dbo->query("SELECT `Category` FROM Questions WHERE `id`='$i'"); // notice how Order is a reserved keyword in sql. 
            $current_category = $stmt->fetchColumn(0);
            $scores[$current_category] += $previousResponses[$i];
            $counts[$current_category] += 1;
            $i++;
        }
        $xaxisCluster2 = array(); 
        $yaxisCluster2 = array();
        // average scores by competency
        echo "<h4>Competency Clusters: </h4>";
        foreach($scores as $k => $score){ // $k is the category string
            $score = $score / $counts[$k];
            $averageScores[$k] = $score;    
        }
        arsort($averageScores);
        foreach($averageScores as $k => $score){ 
            // echo $k . " " . round($score, 2) . "<br />";
            array_push($xaxisCluster2, (string)$k);
            array_push($yaxisCluster2, (double)round($score, 2));
        }
        generateClusterGraph2($xaxisCluster2, $yaxisCluster2); //$competencyArray, $scoreArray
        echo '<img src="resultsgraphcluster2.png" alt="SLC results graph cluster" class="rotate90"/>';
        echo '</div>';
        
    // output descriptions
    
    echo '<br />';
    echo '<div id="admincontent">';
    echo '<br /><h1> Competency Descriptions: </h1><br />';

    $result=mysql_query("SELECT * FROM  `SkillDiscriptions`");
    if (!$result) continue;
    while ($db_field = mysql_fetch_assoc($result)) {
        echo "
                <p><strong>".$db_field['Skill']."</strong></p>
                <p class='leftjustify'>".$db_field['Discription']."</p>
        ";
    }
    
    echo '</div>';
}
?>
                
            </p>
            <?php else: ?>
                <p>
                    <br />
                    <br />
                    <span class="error">You must be logged in to see your Student Leadership Competencies Inventory results.</span> Please <a href="quizhome.php">login</a>.
                    <br />
                </p>
            <?php
            endif;
            
            // get top 5 competencies 
            $averageCompetenciesToShare = array();
            $averageCompetenciesToShare = array_keys($averageScoresToShare);
            $firstCompetency = $averageCompetenciesToShare[0];
            $secondCompetency = $averageCompetenciesToShare[1];
            $thirdCompetency = $averageCompetenciesToShare[2];
            $fourthCompetency = $averageCompetenciesToShare[3];
            $fifthCompetency = $averageCompetenciesToShare[4];
            

            ?>
            </div>
        <br />
                <p><a href="https://www.facebook.com/dialog/feed?app_id=618900464904792&display=popup&caption=My%20top%20five%20leadership%20competencies:&link=http%3A%2F%2Fstudentleadershipcompetencies.com%2Fresults.php&redirect_uri=http%3A%2F%2Fstudentleadershipcompetencies.com%2Fresults.php&description=1:%20<?php echo $firstCompetency;?>,%202:%20<?php echo $secondCompetency;?>,%203:%20<?php echo $thirdCompetency;?>, %204:%20<?php echo $fourthCompetency;?>,%205:%20<?php echo $fifthCompetency;?>.&picture=http%3A%2F%2Fstudentleadershipcompetencies.com%2FSLCinfographic.png" name="share" ><img alt="share with facebook" src="facebooksharebutton.png"></a></p>        
            <p>Return to <a href="quizhome.php">Dashboard</a></p> 

    </body>
</html>