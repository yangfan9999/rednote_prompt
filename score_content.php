<?php

require_once "config.php";



$weights=[

"AskReddit"=>10,

"LifeProTips"=>9,

"AmItheAsshole"=>9,

"NoStupidQuestions"=>8,

"todayilearned"=>7

];



$good=[

"mistake",

"lesson",

"regret",

"secret",

"life",

"money",

"job",

"career",

"relationship",

"women"

];



$bad=[

"linux",

"kernel",

"gpu",

"driver",

"bitcoin",

"api",

"programming"

];



$sql="

SELECT *

FROM reddit_posts

WHERE status=0

LIMIT 500

";


$stmt=$pdo->query($sql);


$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);



foreach($rows as $row){


    $score=0;


    $score+=log($row['upvotes']+1);


    $score+=$row['comments']*0.5;


    $score+=$weights[$row['subreddit']]??0;


    $title=strtolower($row['title']);


    foreach($good as $word){

        if(stripos($title,$word)!==false){

            $score+=5;

        }

    }



    foreach($bad as $word){

        if(stripos($title,$word)!==false){

            $score-=10;

        }

    }


    $update="

    UPDATE reddit_posts

    SET

    hot_score=?,

    status=1

    WHERE id=?

    ";


    $stmt2=$pdo->prepare($update);


    $stmt2->execute([

        $score,

        $row['id']

    ]);



}


echo "score done";