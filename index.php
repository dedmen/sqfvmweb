<head>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php

$sourceText = "Enter text here...";
$resultText = "No errors!";
$activeType = "sqf";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //A update request has come in
var_dump($_POST);
    $activeType = $_POST['type'];
    $sourceText = $_POST['text'];
    $filename = strval(time());
    $parameters = " -a --no-execute-print --no-load-execdir";//." --parse-only";
    $executable = "/home/wolf/projects/vm/sqfvm";

    if ($_POST['type'] == "sqf"){
         file_put_contents("/home/wolf/projects/vm/".$filename, $sourceText);
    

        $output = shell_exec($executable.$parameters." --input-sqf /home/wolf/projects/vm/".$filename." 2>&1");
        $resultText = str_replace("home/wolf/projects/vm/".$filename, "file.sqf", $output);

        //header('genOutput: '.$output); //Debug output
        //header('genParam: '.$parameters); //Debug output
    }
    if ($_POST['type'] == "config"){
         file_put_contents("/home/wolf/projects/vm/".$filename, $sourceText);
    

        $output = shell_exec($executable.$parameters." --input-config /home/wolf/projects/vm/".$filename." 2>&1");
        $resultText = str_replace("home/wolf/projects/vm/".$filename, "file.cpp", $output);

        //header('genOutput: '.$output); //Debug output
        //header('genParam: '.$parameters); //Debug output
    }
    if ($_POST['type'] == "prettysqf") {
        file_put_contents("/home/wolf/projects/vm/".$filename, $sourceText);
        $output = shell_exec($executable.$parameters." --pretty-print /home/wolf/projects/vm/".$filename." 2>&1");
        $resultText = str_replace("home/wolf/projects/vm/".$filename, "file.sqf", $output);
    }
    unlink("/home/wolf/projects/vm/".$filename);
}




echo '
<form method="post" id="usrform">
<div>
    <input type="radio" name="type" value="sqf"'. ($activeType=="sqf" ? 'checked' : '') .'> SQF<br>
    <input type="radio" name="type" value="config"'. ($activeType=="config" ? 'checked' : '') .'> Config<br>
    <input type="radio" name="type" value="prettysqf"'. ($activeType=="prettysqf" ? 'checked' : '') .'> Pretty SQF<br>
    <textarea cols="40" rows="5" name="text">'.$sourceText.'</textarea>
</div>
';

echo '<input type="submit" value="Submit"> </form>';

echo '<textarea cols="40" rows="5">'.$resultText.'</textarea>';

echo "<br/><span>Made by Dedmen ;) with SQF-VM</span>";
?>
</body>
