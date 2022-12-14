<?php
  include "../inc/session.php";

  // 로그인 사용자만 접근
  include '../inc/login_check.php';

  include "../inc/dbcon.php";

  $sql = "SELECT res.res_idx, l.ldg_idx, l.ldg_name, r.r_idx, r.r_name, res.res_checkin, res.res_checkout, res.total_price, res.res_state FROM reservation res JOIN lodging l ON res.ldg_idx = l.ldg_idx JOIN room r ON res.r_idx = r.r_idx WHERE res.u_idx='$s_idx' AND res.res_checkout >= CURDATE() AND res.res_state IN ('1','2');";
  
  // 쿼리 전송
  $result = mysqli_query($dbcon, $sql);

  // 전체 데이터 가져오기
  $total = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>예약내역</title>
  <link rel="shortcut icon" href="../images/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="../css/reset.css" />
  <link rel="stylesheet" type="text/css" href="../css/header.css" />
  <link rel="stylesheet" type="text/css" href="../css/footer.css" />
  <link rel="stylesheet" type="text/css" href="../css/user_reservation.css" />
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>
  <script type="text/javascript" src="../js/includ.js"></script>
  <script>
    $(document).ready(function() {
      $('.user_sub li').mouseover(function(){
        $(this).addClass('menu_select_bar');
        $('.user_sub li').not(this).removeClass('menu_select_bar');
      });

      $('.user_sub li').mouseout(function(){
        $('.user_sub_wrap').addClass('menu_select');
        $('.user_sub2').addClass('menu_select_bar');
        $('.user_sub1').removeClass('menu_select_bar');
        $('.user_sub3').removeClass('menu_select_bar');
      });

      $('.cancle_btn').click(function(){
        var rtn_val = confirm("예약을 취소하시겠습니까?");
        if(rtn_val == true){
          var res_idx = $(this).siblings('input[type=hidden]').val();
          location.href = "res_cancel.php?res_idx="+res_idx;
        }
      });
    });
  </script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <div id="header-include"></div>
      <div class="user_sub_wrap shadow menu_select">
        <ul class="user_sub">
          <li class="user_sub1"><a href="../user/user.html">마이민다</a></li>
          <li class="user_sub2 menu_select_bar"><a href="user_reservation.php">예약내역</a></li>
          <li class="user_sub3"><a href="#">위시리스트</a></li>
        </ul>
      </div>
    </header>

    <!-- content -->
    <main id="content" class="content">
      <div class="user_rv_wrap">
        <h2 class="user_rv_title">예약 내역</h2>
        <ul class="user_rv_tab">
          <li><a href="user_reservation.php" class="click_tab">진행중인 예약</a></li>
          <li><a href="user_last_reservation.php" class="user_rv_tab_menu">지난 예약</a></li>
          <li><a href="user_cancel_reservation.php" class="user_rv_tab_menu">환불 진행 상황</a></li>
        </ul>
        <div class="rv_warning">
          <img src="../images/warning.png" alt="경고 아이콘" class="rv_warning_icon" />
          <p class="rv_warning_msg">
            - 예약 신청 후 아직 체크아웃 날짜가 지나지 않은 예약을 확인하실 수있습니다.<br />
            - '예약취소'를 원하실 경우 예약상태에 해당 버튼을 클릭하시면 예약취소를 하실 수 있습니다.<br />
            - 예약진행상태가 '예약완료'인 예약은 '예약번호'를 클릭하면 상세 페이지에서 숙소정보를 확인해 보실 수 있습니다.<br />
          </p>
        </div>

        <div class="rv_data">
          <h3 class="rv_data_title">예약 정보</h3>
          <div class="rv_table_wrap">
            <table>
              <thead>
                <tr>
                  <th width="100">구분</th>
                  <th width="280">상품명</th>
                  <th width="150">예약번호</th>
                  <th width="150">여행일자</th>
                  <th width="120">결제금액</th>
                  <th width="100">예약상태</th>
                </tr>
              </thead>
              <?php
              if(!$total) {
              ?>
              <!-- 예약 없을 때 -->
              <div class="rv_nodata_wrap">
                <div id="rv_nodata" class="rv_nodata">
                  <p class="rv_nodata_txt1">진행중인 예약이 없습니다.</p>
                  <p class="rv_nodata_txt2">
                    민다에서 숙소와 투어를 예약하고<br />
                    쉽고 편한 여행을 즐겨보세요!
                  </p>
                  <button type="button" class="search_btn">
                    숙소 & 투어 찾기
                  </button>
                </div>
              </div>
              <?php 
              } else { 
                while($array = mysqli_fetch_array($result)){
              ?>
              <tbody id="rv_data_list">
                <tr>
                  <td width="100">숙소</td>
                  <td width="280"><?php echo $array["ldg_name"]." / ".$array["r_name"]; ?></td>
                  <?php 
                    $res_idx = $array["res_idx"];
                    $ldg_idx = $array["ldg_idx"];
                    $r_idx = $array["r_idx"];
                  ?>
                  <td width="150"><a href=#><?php echo substr(str_replace('-','',$array["res_checkin"]), 2, 6).$res_idx.$ldg_idx.$r_idx.$s_idx; ?></a></td>
                  <td width="150"><?php echo $array["res_checkin"]; ?> ~ <br><?php echo $array["res_checkout"]; ?></td>
                  <td width="120"><?php echo number_format($array["total_price"]); ?> 원</td>
                  <td width="100">
                    <?php 
                      $res_state = $array["res_state"];
                      if($res_state == "1") {
                    ?>
                    <p>결제대기</p>
                    <button class="pay_btn btn_hover">결제</button>
                    <?php } else if($res_state == "2") {?>
                      <p>예약완료</p>
                      <input type="hidden" id="res_idx" value="<?php echo $array["res_idx"]; ?>">
                      <button class="cancle_btn btn_hover">예약취소</button>
                    <?php }; ?>
                  </td>
              </tbody>
              <?php 
                };
              }; 
              ?>
            </table>
          </div>
        </div>
      </div>
    </main>

    <!-- footer -->
    <footer>
      <div id="footer-include"></div>
    </footer>
  </div>
</body>

</html>