<?php

require_once "config.php";

$subs=[

"AskReddit",

"LifeProTips",

"todayilearned",

"NoStupidQuestions",

"AmItheAsshole"

];

function getReddit($url){

    $ch=curl_init();

    curl_setopt_array($ch,[

        CURLOPT_URL=>$url,

        CURLOPT_RETURNTRANSFER=>true,

        CURLOPT_USERAGENT=>"Mozilla/5.0 RedditAIBot",

        CURLOPT_TIMEOUT=>30,

        CURLOPT_SSL_VERIFYPEER=>false

    ]);

    $res=curl_exec($ch);

    curl_close($ch);

    return json_decode($res,true);

}



foreach($subs as $sub){

    $urls=[

        "https://www.reddit.com/r/$sub/top.json?t=day&limit=20",

        "https://www.reddit.com/r/$sub/hot.json?limit=20"

    ];


    foreach($urls as $url){

        echo "\n".$url."\n";


        $json=getReddit($url);


        if(empty($json['data']['children'])){

            continue;

        }


        foreach($json['data']['children'] as $item){

            $post=$item['data'];


            $reddit_id=$post['id'];

            $title=$post['title'];

            $content=$post['selftext'];

            $author=$post['author'];

            $ups=$post['ups'];

            $comments=$post['num_comments'];

            $created=$post['created_utc'];

            $permalink="https://www.reddit.com".$post['permalink'];


            $sql="

            INSERT IGNORE INTO reddit_posts

            (

            reddit_id,

            subreddit,

            title,

            content,

            author,

            upvotes,

            comments,

            post_url,

            created_utc

            )

            VALUES

            (

            ?,?,?,?,?,?,?,?,?

            )

            ";



            $stmt=$pdo->prepare($sql);


            $stmt->execute([

                $reddit_id,

                $sub,

                $title,

                $content,

                $author,

                $ups,

                $comments,

                $permalink,

                $created

            ]);


        }


    }


}


echo "Done";