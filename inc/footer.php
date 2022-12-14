<?php
  include "session.php";
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOOTER</title>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
  </script>
  <script type="text/javascript" src="http://localhost/KDT-1st-project-minda/js/footer.js"></script>
</head>

<body>
  <div id="footer" class="footer">
    <h2 class="hide">사이트 이용 안내</h2>

    <div class="footer_term">
      <h3 class="hide">약관 및 정책</h3>
      <ul>
        <li><a href="#">회사소개</a></li>
        <li><a href="#">파트너 가입</a></li>
        <li><a href="#">취소환불규정</a></li>
        <li><a href="#">고객센터</a></li>
        <li><a href="#" class="notice">공지사항</a></li>
        <li><a href="#">이용약관개인정보처리방침</a></li>
        <li><a href="#">사업자정보확인</a></li>
      </ul>
    </div>

    <div class="footer_side_wrap">
      <input type="hidden" name="on_user" id="on_user" class="on_user" value="<?php echo $s_idx ?>">
      <input type="hidden" name="on_partner" id="on_partner" class="on_partner" value="<?php echo $sp_idx ?>">
      <a href="#" class="footer_gopatner">숙소 파트너홈 바로가기</a>
      <div class="footer_side indent">
        <h3 class="hide">SNS</h3>
        <ul>
          <li class="footer_sns_fb"><a href="#">페이스북</a></li>
          <li class="footer_sns_blog"><a href="#">블로그</a></li>
          <li class="footer_sns_instar"><a href="#">인스타그램</a></li>
        </ul>
        <a href="#"
          class="footer_qna indent">고객센터문의</a>
      </div>
    </div>

    <!-- 파트너 가입 팝업 -->
    <div class="ptn_modal_bg">
      <div class="ptn_pop_signup">
        <form name="pertner_signup_form" id="pertner_signup_form"
          action="http://localhost/KDT-1st-project-minda/partner/partner_insert.php" method="post">
          <h3 class="ptn_pop_logo indent">민다파트너</h3>
          <button type="button" class="ptn_pop_cancel_btn indent">닫기</button>
          <div class="ptn_pop_line"></div>
          <fieldset>
            <legend class="ptn_pop_signup_title">파트너 등록</legend>
            <p class="ptn_pop_txt">민다 파트너가 되어 새로운 수익을 만들어 보세요!</p>

            <div class="ptn_pop_info_wrap">
              <div class="ptn_pop_name_wrap">
                <span class="ptn_pop_title">파트너명</span>
                <input type="text" name="p_name" id="ptn_pop_name" class="ptn_pop_input" maxlength="20"
                  placeholder="회사명, 숙소명등 대표되는 이름을 작성해주세요.">
                <br><span id="ptn_err_name" class="ptn_pop_err_txt"></span>
              </div>
              <div class="ptn_pop_num_wrap">
                <span class="ptn_pop_title">사업자번호</span>
                <input type="text" name="p_biznum" id="ptn_pop_num" class="ptn_pop_input" maxlength="20"
                  placeholder="국내/해외 사업자등록번호를 입력해주세요">
                <br><span id="ptn_err_num" class="ptn_pop_err_txt"></span>
              </div>
              <div class="ptn_pop_tel_wrap">
                <span class="ptn_pop_title">업체 연락처</span>
                <input type="text" name="p_phone" id="ptn_pop_tel" class="ptn_pop_input" maxlength="20"
                  placeholder="숫자만 입력해주세요.">
                <br><span id="ptn_err_tel" class="ptn_pop_err_txt"></span>
              </div>
            </div>

            <div class="ptn_pop_term">
              <p class="ptn_pop_term_title">민다 서비스 판매대행 약관에 동의해주세요.</p>
              <div class="ptn_pop_term_wrap">
                <div class="ptn_pop_checkbox_wrap">
                  <input type="checkbox" class="ptn_pop_checkbox01 ptn_nomal" id="ptn_pop_checkbox01">
                  <label for="ptn_pop_checkbox01">(필수) 판매 이용약관</label>
                  <a href="#" class="ptn_pop_viewall">전체보기</a>
                </div>
                <div class="ptn_pop_checkbox_wrap">
                  <input type="checkbox" class="ptn_pop_checkbox02 ptn_nomal" id="ptn_pop_checkbox02">
                  <label for="ptn_pop_checkbox02">(필수) 서비스 이용약관</label>
                  <a href="#" class="ptn_pop_viewall">전체보기</a>
                </div>
                <div class="ptn_pop_checkbox_wrap">
                  <input type="checkbox" class="ptn_pop_checkbox03 ptn_nomal" id="ptn_pop_checkbox03">
                  <label for="ptn_pop_checkbox03">(필수) 개인정보 수집 및 이용</label>
                  <a href="#" class="ptn_pop_viewall">전체보기</a>
                </div>
              </div>
              <div class="ptn_pop_check_all_wrap">
                <input type="checkbox" class="ptn_pop_check_all" id="ptn_pop_check_all">
                <label for="ptn_pop_check_all" class="ptn_pop_check_all_txt">전체 약관 동의</label>
                <span id="ptn_pop_err_apply" class="ptn_pop_check_err_txt"></span>
              </div>
            </div>

            <div class="ptn_pop_modal_btn">
              <button type="button" class="ptn_signup_cancel_btn btn_hover_cancel">취소</button>
              <button type="button" id="ptn_signup_btn" class="ptn_signup_btn btn_hover">회원가입</button>
            </div>
          </fieldset>
          </from>
      </div>
    </div>

    <div class="footer_info">
      <h3>INFORMATION</h3>
      <div class="footer_info_txt1">
        <p class="footer_txt">㈜민다 대표 : 김윤희 </p>
        <p class="footer_txt">사업자등록번호 : 101-86-28116 </p>
        <p class="footer_txt">관광사업등록증 : 제 2020-000054호 </p>
        <p>통신판매업신고 : 제 2020-서울마포-3698호</p>
      </div>
      <div class="footer_info_txt2">
        <p class="footer_txt">고객센터 : 1661-2892 </p>
        <p class="footer_txt">FAX : 02-722-3478 </p>
        <p>운영시간 : 평일 10시~12시/13시~18시(주말, 공휴일 휴무)</p>
      </div>
      <div class="footer_info_txt3">
        <p class="footer_txt">이메일 : help@theminda.com(일반문의), biz@theminda.com(사업제휴)</p>
        <address>서울특별시 마포구 성산로2길 55, 샤인빌딩 602호 (성산동)</address>
      </div>
      <p>Copyright © Minda Co., Ltd. All rights reserved.</p>
    </div>


    <div class="footer_bot_warp">
      <div class="footer_bot">
        <p>(주)민다의 사전 서면동의 없이 민다 사이트(PC, 모바일, 앱)의 일체의 정보, 콘텐츠 및 UI 등을 상업적 목적으로 전재, 전송, 스크래핑 등 무단 사용할 수 없습니다.</p>

        <p>(주)민다는 통신판매중개자이며 통신판매의 당사자가 아닙니다.<br>
          따라서 (주)민다는 상품·거래정보 및 거래와 관련하여 판매자의 고의 또는 과실로 소비자에게 발생하는 손해에 대해 일체 책임을 지지 않습니다.</p>
      </div>
    </div>
  </div>
</body>

</html>