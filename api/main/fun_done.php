<?php
function done_rt($rt_id, $title, $m_days, $m_date, $m_time, $alarm, $on_feed, $memo, $user_id, $done) {
    // 루틴 수행 데이터(과거 내역) 추가하기
    // 루틴 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 1로 변경
    $check = mq("SELECT * FROM rt_done WHERE rt_id = '$rt_id' AND m_date = '$m_date'");
    $count = mysqli_num_rows($check);
    if($count == 0) {
        $insert = mq("INSERT rt_done SET
        title = '$title',
        m_days = '$m_days',
        m_date = '$m_date',
        m_time = '$m_time',
        memo = '$memo',
        rt_id = '$rt_id',
        user_id = '$user_id',
        done = '$done'
        ");

        if($insert) {
            echo "추가됨";
        } else {
            echo "추가 안됨";
        }
    } else {
        mq("UPDATE rt_done SET
        done = '$done'
        WHERE rt_id = '$rt_id' AND m_date = '$m_date'
        ");
    }
}

function done_todo($title, $m_type, $m_days, $m_date, $m_time, $alarm, $on_feed, $memo, $user_id) {
    // 완료 처리한 할 일의 다음 수행 날짜 데이터가 있는지 없는지 확인하기
    $check = mq("SELECT * FROM rt_todo WHERE title = '$title' AND m_date = '$m_date'");
    $count = mysqli_num_rows($check);

    // 할 일과 동일한 제목, 그리고 다음 수행 날짜를 가진 데이터가 없으면 다음에 수행할 할 일 추가함
    if($count == 0) mq("INSERT rt_todo SET
    m_type = '$m_type',
    title = '$title',
    m_days = '$m_days',
    m_date = '$m_date',
    m_time = '$m_time',
    alarm = '$alarm',
    on_feed = '$on_feed',
    memo = '$memo',
    user_id = '$user_id'
    ");
}

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
    mq("UPDATE action SET done = '$done' WHERE rt_id = '$rt_id'");

    $sql = mq("SELECT * FROM action WHERE rt_id = '$rt_id'");
    while($action = $sql->fetch_assoc()) {
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
}
?>