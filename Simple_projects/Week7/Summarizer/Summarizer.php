<?php
require_once 'src/vendor/autoload.php';


$textapi = new AYLIEN\TextAPI("f3dd4a39", "cd36b937142a6f0520a67cf154fcac78");

$articleTitle = $_POST['article-title'];
$articleBody = $_POST['article-body'];
$articleSize = strlen($articleBody);
$summarySize = $articleSize/2000;
$summarySize = (int)$summarySize;
if($summarySize < 3) {
    $summarySize = 3;
} elseif ($summarySize > 10) {
    $summarySize = 10;
}
$summary = $textapi->Summarize(array('title' => $articleTitle, 'text' => $articleBody, 'sentences_number' => $summarySize));
foreach ($summary->sentences as $sentece) {
  echo $sentece,"\n";
}


