<?php 
include_once "/htdocs/util/db_con.php";

$url = "https://fcm.googleapis.com/fcm/send"; 
$serverKey = 'AAAAxBTtrNk:APA91bHulhtjaswBGKWngPPDh4OIs1hvZSNpRGjqL8_zPPRu7wm6qZPDAzIpbvTKoG7QXcyNP1htVsCBvf0wFBwGbfHnwdqR4isHAgoj8O-OvFQC2Bjhzc8J3_7RcVU4MlqtmfeXTJsC';
$headers = array(); 
$headers[] = 'Content-Type: application/json'; 
$headers[] = 'Authorization: key='.$serverKey;

$date = date("Y-m-d"); // 현재 날짜
$time = date("H:i"); // 현재 시각

// 현재 날짜 및 시각에 수행 예정인 루틴 및 할 일 데이터 가져오기
$mq = mq("SELECT * FROM rt_todo WHERE m_date='$date' AND m_time='$time' AND alarm=1 AND done=0");

while($rt = $mq->fetch_assoc()) {
    $data = [
        'id'   => $rt['id'],
        'mType' => $rt['m_type'],
        'rtTitle'   => $rt['title'],
        'mDays' => $rt['m_days'],
        'mDate' => $rt['m_date'],
        'mTime' => $rt['m_time'],
        'alarm'   => $rt['alarm'],
        'onFeed'   => $rt['on_feed'],
        'memo' => $rt['memo'],
        'userId'   => $rt['user_id'],
        'done'   => $rt['done'],
        'createdAt' => $rt['created_at']
    ];

    $user = mq("SELECT token FROM user WHERE id = '$rt[user_id]'");
    $result = mysqli_fetch_array($user);

    $token = $result['token']; 
    $title = $rt['title'];
    $body = $rt['title']." 수행할 시각입니다!";
    $notification = array(
        'type' => 4,
        'title' =>$title,
        'body' => $body,
        'target' => $rt['id']);
    $arrayToSend = array(
        'to' => $token, 
        'notification' => $notification,
        'priority'=>'high');
    $json = json_encode($arrayToSend); 


    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); 

    //Send the request 
    $response = curl_exec($ch); 

    //Close request 
    if ($response === FALSE) { 
        die('FCM Send Error: ' . curl_error($ch)); 
    }
}

curl_close($ch);
?>
