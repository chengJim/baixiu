<?php
require '../functions.php';
xiu_get_current_user();
?>

<!-- 评论管理:  利用 Ajax + 模板 渲染页面 -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <style>

  <!-- loading 特效样式 2 -->
  .lds-hourglass {
    display: inline-block;
    position: relative;
    width: 64px;
    height: 64px;
  }
  .lds-hourglass:after {
    content: " ";
    display: block;
    border-radius: 50%;
    width: 0;
    height: 0;
    margin: 6px;
    box-sizing: border-box;
    border: 26px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-hourglass 1.2s infinite;
  }
  @keyframes lds-hourglass {
    0% {
      transform: rotate(0);
      animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    }
    50% {
      transform: rotate(900deg);
      animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    100% {
      transform: rotate(1800deg);
    }
  }





  <!-- loading 特效样式 1 -->

    .flip-txt-loading {
      font: 26px Monospace;
      letter-spacing: 5px;
      color: #AF3F3F;
      z-index: 999;
    }
    .flip-txt-loading > span {
      animation: flip-txt  2s infinite;
      display: inline-block;
      transform-origin: 50% 50% -10px;
      transform-style: preserve-3d;
    }
    .flip-txt-loading > span:nth-child(1) {
      -webkit-animation-delay: 0.10s;
              animation-delay: 0.10s;
    }
    .flip-txt-loading > span:nth-child(2) {
      -webkit-animation-delay: 0.20s;
              animation-delay: 0.20s;
    }
    .flip-txt-loading > span:nth-child(3) {
      -webkit-animation-delay: 0.30s;
              animation-delay: 0.30s;
    }
    .flip-txt-loading > span:nth-child(4) {
      -webkit-animation-delay: 0.40s;
              animation-delay: 0.40s;
    }
    .flip-txt-loading > span:nth-child(5) {
      -webkit-animation-delay: 0.50s;
              animation-delay: 0.50s;
    }
    .flip-txt-loading > span:nth-child(6) {
      -webkit-animation-delay: 0.60s;
              animation-delay: 0.60s;
    }
    .flip-txt-loading > span:nth-child(7) {
      -webkit-animation-delay: 0.70s;
              animation-delay: 0.70s;
    }
    @keyframes flip-txt  {
      to {
        -webkit-transform: rotateX(1turn);
                transform: rotateX(1turn);
      }
    }

  </style>
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 发生XXX错误
      </div> -->
      
      <!-- 表操作: 但内容选中时才显示 -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <!-- 分页插件 的容器元素 -->
        <ul class="pagination pagination-sm pull-right"></ul>
      </div>
      <!-- 评论列表 -->
      <table class="table table-striped table-bordered table-hover">
        <!-- 表头 -->
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th width="500">评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="150">操作</th>
          </tr>
        </thead>
        <!-- 表身:  数据为空, 将用ajax获取数据插入于此 -->
        <tbody></tbody>

      </table>
    </div>
  </div>

  <?php $current_page = 'comments'; ?>
  <?php include 'inc/sidebar.php'; ?>
  <!-- loading 特效 容器   需要控制它们的位置居中,显示和隐藏时机,  此处略, 可使用display:flex-->
  <div class="flip-txt-loading">
    <span>L</span><span>o</span><span>a</span><span>d</span><span>i</span><span>n</span><span>g</span>
  </div>

  <div class="lds-hourglass"></div>

  <!--JS-->
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <!-- jsrender 模板 -->
  <script id="comment_tmpl" type="text/x-jsrender">

    {{for comments}}
      <tr{{if status = 'held'}} class = "warning"{{else status = 'rejected'}} class = "danger" {{/if}} data-id = {{:id}}>
        <td class="text-center"><input type="checkbox"></td>
        <td>{{:author}}</td>
        <td>{{:content}}</td>
        <td>《{{:post_title}}》</td>
        <td>{{:created}}</td>
        <td>{{:status}}</td> 
        <td class="text-center">
          {{if status === 'held'}}
            <a href="post-add.html" class="btn btn-info btn-xs">驳回</a>
            <a href="post-add.html" class="btn btn-warning btn-xs">拒绝</a>
          {{/if}}
            <a href="javascript:;" class="btn btn-danger btn-xs btn-delete">删除</a>
        </td>
      </tr>
    {{/for}}
  </script>
  
  <script>

    /* -- 将nprogress 进度条 函数 注册为.ajaxStart和ajaxStop事件处理程序. -- */
    /* -- 这是ajax请求显示nprogress的方法, 页面普通请求则上下用<script>标签. -- */
    $(document)
     .ajaxStart(function () {
       NProgress.start()
     })
     .ajaxStop(function () {
       NProgress.done()
     })

    /* -- 用Ajax请求发送数据, 因为这里传递的空的页面 -- */
    
    // $.getJSON('/admin/api/comments-list.php', { page:2 }, function (res) {
    //   var html = $('#comment_tmpl').render({ comments: res })
    //   $('tbody').html(html)
    // })   
    var $pagination = $('.pagination')
    var $commentTmpl = $('#comment_tmpl')
    var $tbody = $('tbody')
    var currentPage = 1

    function loadPageData (page) {
      $.getJSON('/admin/api/comments-list.php', { page: page }, function (data) {
        // console.log(data);
        // 解决最大页刷新问题
          if (page > data.total_pages) { //大于最大页,则显示最大页
            loadPageData(data.total_pages)
            return false
          }
          /* 分页插件加载:   在ajax请求完毕后加载 */
          $pagination.twbsPagination('destroy')
          $pagination.twbsPagination({
            first: '首页', 
            last: '末页',
            prev: '上一页',
            next: '下一页',
            startPage: page,
            totalPages: data.total_pages,
            visiablePages: 5,
            initiateStartPageClick: false,
            onPageClick: function (e, page) {//回调参数page为点击的页数
              // 第一次初始化时就会触发, 
              // 所以上面initiateStartPageClick要为false,否则重复触发.
              loadPageData(page)
            }
          })

        /* -- 模板渲染 产生HTML代码 -- */
        // data => { total_pages: 5, comments: [] }
        var html = $commentTmpl.render({ comments: data.comments })
        $tbody.fadeOut().html(html).fadeIn()
        currentPage = page
      })
    }
    loadPageData(currentPage)

    $tbody.on('click', '.btn-delete', function () {
      // 删除单条数据
      // 1、先拿到x需要删除的数据ID
      var tr = $(this).parent().parent()
      var id = tr.data('id')
      // 2、发送一个AJAX请求告诉服务端要删除哪一条具体的数据
      $.get('/admin/api/comment-delete.php', { id: id }, function (res) {
        if (!res) return
        // 3、根据服务端返回的删除是否成功决定是否应该在界面上移除这个元素
        // tr.remove()
        // 一般不是移除，而是重新载入当前页面数据
        loadPageData(currentPage)
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
