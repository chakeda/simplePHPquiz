<?php
// creates the graphs using jpgraph. 8 functions create 8 images 
include_once 'includes/jpgraph/jpgraph.php';
include_once 'includes/jpgraph/jpgraph_bar.php';

// note about graphs: 
// graph images are turned clockwise 90 degrees in html, and labels are rotated clockwise 90 degrees as well

function generateCompetencyGraphTop($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#00FF00");

    // Display the graph
    $graph->Stroke("resultsgraphtop.png");
}

function generateCompetencyGraphMiddle($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600, 'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom


    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);

    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#FFFF00");

    // Display the graph
    $graph->Stroke("resultsgraphmiddle.png");
}

function generateCompetencyGraphBottom($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#FF0000");

    // Display the graph
    $graph->Stroke("resultsgraphbottom.png");
}

///// 


function generateCompetencyGraphTop2($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#00FF00");

    // Display the graph
    $graph->Stroke("resultsgraphtop2.png");
}

function generateCompetencyGraphMiddle2($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#FFFF00");

    // Display the graph
    $graph->Stroke("resultsgraphmiddle2.png");
}

function generateCompetencyGraphBottom2($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#FF0000");

    // Display the graph
    $graph->Stroke("resultsgraphbottom2.png");
}

//// 

function generateClusterGraph($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor(array("green","#98FB98","yellow","orange", "cyan", "blue", "red", "pink", "purple"));

    // Display the graph
    $graph->Stroke("resultsgraphcluster.png");
}
function generateClusterGraph2($competencyArray, $scoreArray){
    $data1y=$scoreArray;


    // Create the graph. These two calls are always required
    $graph = new Graph(600,600,'auto');
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    
    $graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
    $graph->SetBox(false);
    
    if ($scoreArray[0]){
        $showTheFive = 100.0 * ((5.0 / $scoreArray[0]) - 1.0 ); // algebraeic formula using SetGrace() to make axis display 5.0 respective to highest value in dataset
        $graph->yscale->SetGrace($showTheFive);
    }
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($competencyArray);
    $graph->xaxis->SetLabelAngle(90);
    $graph->yaxis->SetLabelAngle(90);
    $graph->setMargin(25,25,25,275); // left right top bottom
    $graph->yaxis->HideTicks(false,false);

    // Create the bar plots
    $b1plot = new BarPlot($data1y);

    // Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
    // ...and add it to the graPH
    $graph->Add($gbplot);
    $b1plot->value->Show();
    $b1plot->value->SetAngle(90);


    $b1plot->SetColor("white");
    $b1plot->SetFillColor(array("green","#98FB98","yellow","orange", "cyan", "blue", "red", "pink", "purple"));

    // Display the graph
    $graph->Stroke("resultsgraphcluster2.png");
}
?>
