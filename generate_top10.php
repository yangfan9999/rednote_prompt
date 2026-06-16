<?php

require_once "config.php";



$sql="

SELECT *

FROM reddit_posts

WHERE status=1

ORDER BY hot_score DESC

LIMIT 10

";


$stmt=$pdo->query($sql);


$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);



$result=[];



foreach($rows as $row){


    $result[]=[

        "id"=>$row['id'],

        "reddit_id"=>$row['reddit_id'],

        "subreddit"=>$row['subreddit'],

        "title"=>$row['title'],

        "content"=>$row['content'],

        "upvotes"=>$row['upvotes'],

        "comments"=>$row['comments'],

        "score"=>$row['hot_score'],

        "url"=>$row['post_url']

    ];


}



file_put_contents(

    "output/top10.json",

    json_encode(

        $result,

        JSON_PRETTY_PRINT|

        JSON_UNESCAPED_UNICODE

    )

);



echo "top10 exported";