<?php
    $con=mysqli_connect('localhost','root','','dataofuser');
    $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v11.0/101935432178993?fields=posts%7Bfull_picture%2Cmessage%2Ccreated_time%7D%2Cname%2Cpicture&access_token=EAADH9q9JuC8BAKzVaaOgdOfPPclT5LmcsAqjStYE8ZBZB0jFlfkvBI3uYU4UJlM6nuAq60EUrpcZB5XZBlxRBIQnbYWd1JpCgcXQDqiUeAlZBByDPk7P6OMgFUnoOZC0pBqea33CPX4PeEhxIEEilQgZAz1SCPo47sUIQS8zlhthlgTv3ytI9MzZCblHUATnnzCvThTKsnkrHt9szTFkn03o');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
    $result=json_decode($result);
    mysqli_query($con, "delete from user_info");  
    // echo '<pre>';
    // print_r($result);

    foreach($result->posts->data as $list) {
        $message ='';
        $full_picture ='';
        $page_name ='';
        $page_picture ='';

        if(isset($list->message)){
            $message=$list->message;
        }

        if(isset($list->full_picture)){
            $full_picture=$list->full_picture;
        }
        $created_time = $list->created_time;
        $page_name = $result->name;
        $page_picture = $result->picture->data->url;

        mysqli_query($con,"insert into user_info(message,full_picture,created_time,page_name,page_picture) values('$message','$full_picture','$created_time','$page_name','$page_picture')");
    }
?>

