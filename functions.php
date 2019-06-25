<?php

require_once 'config.php';

/* 封装大家公用的函数 */
session_start(); // 引入了此functions.php的页面都会自动开始session.

/**
 * 访问控制
 * 获取当前登录用户信息，如果没有获取到则自动跳转到登录页面
 * @return [type] [description]
 */
function xiu_get_current_user () {

  if (empty($_SESSION['current_login_user'])) {
    header('Location: /admin/login.php'); // 没有当前登录用户信息，意味着没有登录
    exit(); // 没有必要再执行之后的代码
  }
  return $_SESSION['current_login_user'];
}

/**
 * 查询获取多条数据
 */
function xiu_fetch_all ($sql) {
  $result = array(); //> 索引数组套返回的关联数组, 并且即使没有获取到数据,也返回空数组.

  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    exit('连接失败');
  }
  
  if ($query = mysqli_query($conn, $sql)) { //判断返回值true还是false
    while ($row = mysqli_fetch_assoc($query)) {
      $result[] = $row;
    }
    mysqli_free_result($query);
  }

  mysqli_close($conn);
  return $result;
}

/**
 * 查询单条数据
 * => 关联数组
 */
function xiu_fetch_one ($sql) {
  $res = xiu_fetch_all($sql);
  return isset($res[0]) ? $res[0] : null;
}

/**
 * 执行增删改语句
 */
function xiu_execute ($sql) {
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    exit('连接失败');
  }

  $query = mysqli_query($conn, $sql);
  if (!$query) {
    // 查询失败
    return false;
  }

  // 对于增删修改类的操作都是获取受影响行数
  $affected_rows = mysqli_affected_rows($conn);

  mysqli_close($conn);

  return $affected_rows; //结果
}
