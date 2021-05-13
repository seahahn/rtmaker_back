<?php
function done_action($action_id, $m_date, $title, $m_time, $memo, $rt_id, $user_id, $done, $pos) {
    // 행동 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 1로 변경
    $check = mq("SELECT * FROM action_done WHERE action_id = '$action_id' AND m_date = '$m_date'");
    $count = mysqli_num_rows($check);
    if($count == 0) {
        mq("INSERT action_done SET
        title = '$title',
        m_time = '$m_time',
        m_date = '$m_date',
        memo = '$memo',
        rt_id = '$rt_id',
        action_id = '$action_id',
        user_id = '$user_id',
        done = '$done',
        pos = '$pos'
        ");
    } else {
        mq("UPDATE action_done SET
        done = '$done'
        WHERE action_id = '$action_id' AND m_date = '$m_date'
        ");
    }
}

function done_actions($rt_id, $m_date, $done) {
    $sql = mq("SELECT * FROM action WHERE rt_id = '$rt_id'");
    while($action = $sql->fetch_assoc()) {
        // $data = [
        //     'id'   => $action['id'],
        //     'actionTitle'   => $action['title'],
        //     'time' => $action['m_time'],
        //     'memo' => $action['memo'],
        //     'm_date' => $action['m_date'],
        //     'rtId' => $action['rt_id'],
        //     'userId'   => $action['user_id'],
        //     'done'   => $action['done'],
        //     'pos'   => $action['pos'],
        //     'createdAt' => $action['created_at']
        // ];
        $check = mq("SELECT * FROM action_done WHERE action_id = '$action[id]' AND m_date = '$m_date'");
        $count = mysqli_num_rows($check);
        if($count == 0) {
            mq("INSERT action_done SET
            title = '$action[title]',
            m_time = '$action[m_time]',
            m_date = '$m_date',
            memo = '$action[memo]',
            rt_id = '$rt_id',
            action_id = '$action[id]',
            user_id = '$action[user_id]',
            done = '$done',
            pos = '$action[pos]'
            ");
        } else {
            mq("UPDATE action_done SET
            done = '$done'
            WHERE action_id = '$action[id]' AND m_date = '$m_date'
            ");
        }
    }

    // $check = mq("SELECT * FROM action_done WHERE rt_id = '$rt_id' AND m_date = '$m_date'");
    // $count = mysqli_num_rows($check);
    // if($count == 0) {
    //     mq("INSERT action_done SET
    //     title = '$title',
    //     m_time = '$m_time',
    //     m_date = '$m_date',
    //     memo = '$memo',
    //     rt_id = '$rt_id',
    //     action_id = '$action_id',
    //     user_id = '$user_id',
    //     done = '$done',
    //     pos = '$pos'
    //     ");
    // } else {
    //     mq("UPDATE action_done SET
    //     done = '$done'
    //     WHERE action_id = '$action_id' AND m_date = '$m_date'
    //     ");
    // }
}
?>