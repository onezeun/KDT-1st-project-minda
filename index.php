<?php
  include "inc/session.php";

  // DB 연결
  include "inc/dbcon.php";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>민다</title>
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/header.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/slick.css" />
  <link rel="stylesheet" type="text/css" href="css/slick-theme.css" />
  <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
  </script>
  <script type="text/javascript" src="js/includ.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script type="text/javascript" src="js/slick.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</head>

<body>

  <div class="wrap">
    <!-- header -->
    <header>
      <div id="header-include"></div>
    </header>

    <!-- content -->
    <main id="content" class="content">
      <div class="mb_wrap">
        <section class="mb">
          <h2 class="hide">메인배너</h2>
          <div class="mb_search">
            <h3>어디로 떠날까요?</h3>
            <div class="mb_search_list">
              <ul>
                <li class="mb_search_room search_bar_boder"><a href="#">숙박</a></li>
                <li class="mb_search_tour"><a href="#">투어</a></li>
              </ul>
              <div class="mb_search_bar clearfix"></div>
            </div>
            <div class="mb_search_form"></div>
            <form name="search_room_form" id="search_room_form" action="lodging/lodging_search.php" method="post">
              <input type="text" name="srch_txt" class="mb_search_input1" placeholder="도시명 또는 숙소명을 입력해주세요"><br>
              <input type="text" id="daterange_room" class="mb_search_input2" placeholder="체크인 - 체크아웃" readonly><br>
              <input type="hidden" name="srch_start" id="srch_start">
              <input type="hidden" name="srch_end" id="srch_end">
              <button type="submit" class="mb_search_btn">숙소 검색</button>
            </form>

            <form name="search_tour_form" id="search_tour_form" class="search_tour_form" action="lodging/lodging_search.php" method="post">
              <input type="text" class="mb_search_input1" placeholder="도시명 또는 투어명을 입력해주세요"><br>
              <input type="text" id="daterange_tour" class="mb_search_input2" placeholder="투어(시작)날짜" readonly><br>
              <button type="submit" class="mb_search_btn">투어 검색</button>
            </form>
          </div>

          <div class="mb_reco">
            <h3 class="hide">추천 여행지</h3>
            <ul class="mb_reco_slide">
              <li class="mb_reco_cont1">
                <a href="lodging/lodging_search.php?srch_txt=%이탈리아%" class="block">
                  <div class="mb_reco_txt_wrap">
                    <p class="mb_reco_txt1">역사가 살아 숨쉬는 이탈리아</p>
                    <p class="mb_reco_txt2">문화유산의 천국! 이탈리아로 떠나요</p>
                  </div>
                </a>
              </li>
              <li class="mb_reco_cont2">
                <a href="lodging/lodging_search.php?srch_txt=%미국%" class="block">
                  <div class="mb_reco_txt_wrap">
                    <p class="mb_reco_txt1">어디에도 없는 매력 미국으로 떠나요</p>
                    <p class="mb_reco_txt2">가장 힙하고, 아름답고, 신나는 여행</p>
                  </div>
                </a>
              </li>
              <li class="mb_reco_cont3">
                <a href="lodging/lodging_search.php?srch_txt=%파리%" class="block">
                  <div class="mb_reco_txt_wrap">
                    <p class="mb_reco_txt1">당신의 로맨스를 찾을 곳, 파리</p>
                    <p class="mb_reco_txt2">낭만적인 파리를 즐겨보세요</p>
                  </div>
                </a>
              </li>
            </ul>
            <div class="carousel">
              <span id="carousel_page_bg" class="carousel_page_bg"><span id="carousel_page" class="carousel_page"><span
                    id="now_page"></span>/<span id="total_page"></span></span></span>
              <a href="#" id="carousel_prev" class="carousel_prev indent">이전</a>
              <a href="#" id="carousel_next" class="carousel_next indent">다음</a>
              <a href="#" id="carousel_play" class="carousel_play indent">재생</a>
              <a href="#" id="carousel_stop" class="carousel_stop indent">일시정지</a>
            </div>
            <p class="movemsg">※ 클릭 시 해당 도시 숙소 검색 페이지로 이동합니다.</p>
          </div>
        </section>
      </div>


      <section class="best_room">
        <h2 class="slide_title">베스트 한인민박</h2>
        <ul id="room_slide" class="card_slide">
          <?php 
            $sql = "SELECT l.ldg_idx, l.ldg_name, l.ldg_main_img, l.ldg_country, l.ldg_city, MIN(r.r_price) r_price, AVG(rv.rv_score) rv_score FROM lodging l JOIN room r ON l.ldg_idx = r.ldg_idx LEFT OUTER JOIN review rv ON l.ldg_idx = rv.ldg_idx GROUP BY ldg_idx;";
            $result = mysqli_query($dbcon, $sql);
            $num = mysqli_num_rows($result);
            if(!$num) {
          ?>
          <p class="room_txt">등록된 숙소가 없습니다.</p>
          <?php  
            };
            while($array = mysqli_fetch_array($result)){ 
          ?>
          <li>
            <div id="card" class="card">
              <a href="lodging/lodging_detail.php?ldg_idx=<?php echo $array['ldg_idx']; ?>" class="block">
                <img src="<?php echo "partner/room/images/".$array['ldg_main_img']; ?>" alt="숙소대표이미지">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category"><?php echo $array['ldg_country']."·".$array['ldg_city']; ?></span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">132</span>
                    </div>
                  </div>
                  <h3 class="card_title"><?php echo $array['ldg_name']; ?></h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <?php 
                        $avg = $array['rv_score'];
                        if(!$avg) {
                      ?>
                      <span class="star_null">등록된 리뷰가 없습니다</span>
                      </div>
                      <?php }else {?>
                      <span class="star">
                        ★★★★★
                        <span style="width :<?php echo ($avg*20-3) ."%"; ?> ">★★★★★</span>
                      </span>
                      <span class="star_gpa"><?php echo $avg?></span>
                    </div>
                    <?php }; ?>
                    <div>
                      <span class="card_price"><?php echo number_format($array['r_price']); ?> 원</span><span
                        class="card_price_std">1박</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>
          <?php };?>
        </ul>
        <a href="#" id="room_btn1" class="card_prev">이전</a>
        <a href="#" id="room_btn2" class="card_next">다음</a>
      </section>


      <section class="best_tour">
        <h2 class="slide_title">베스트 투어</h2>

        <ul id="tour_slide" class="card_slide">
          <li>
            <div id="card" class="card tour1">
              <a href="#" class="block">
                <img src="images/bestour_image01.jpg" alt="프랑스파리몽생미셸야경투어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">프랑스·파리</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">107</span>
                    </div>
                  </div>
                  <h3 class="card_title">몽생미셸 야경투어 + 지베르니 모네 정원</h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <span class="card_review_sign">리뷰5.0</span><span class="card_review_count">11</span>
                    </div>
                    <div>
                      <span class="card_price">210,000 원</span><span class="card_price_std">1인</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>
          <li>
            <div id="card" class="card tour2">
              <a href="#" class="block">
                <img src="images/bestour_image02.jpg" alt="오스트리아할슈타트투어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">오스트리아·할슈타트</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">1</span>
                    </div>
                  </div>
                  <h3 class="card_title">하루 만에 만나는 할슈타트 투어</h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <span class="card_review_sign">리뷰5.0</span><span class="card_review_count">6</span>
                    </div>
                    <div>
                      <span class="card_price">86,544 원</span><span class="card_price_std">1인</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div id="card" class="card tour3">
              <a href="#" class="block">
                <img src="images/bestour_image03.jpg" alt="이탈리아로마시내워킹투어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">이탈리아·로마</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">63</span>
                    </div>
                  </div>
                  <h3 class="card_title">로마 시내 워킹투어 (반나절) 알고봐야 감탄하는 로마여행</h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <span class="card_review_sign">리뷰5.0</span><span class="card_review_count">21</span>
                    </div>
                    <div>
                      <span class="card_price">30,000 원</span><span class="card_price_std">1인</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div id="card" class="card tour4">
              <a href="#" class="block">
                <img src="images/bestour_image04.jpg" alt="미국라스베가스1박2일캠핑6대캐년투어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">미국·라스베가스</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">64</span>
                    </div>
                  </div>
                  <h3 class="card_title">럭셔리 1박 2일 캠핑 6대캐년투어(그랜드, 브라이스)</h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <span class="card_review_sign">리뷰5.0</span><span class="card_review_count">25</span>
                    </div>
                    <div>
                      <span class="card_price">310,000 원</span><span class="card_price_std">1인</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div id="card" class="card tour3">
              <a href="#" class="block">
                <img src="images/bestour_image03.jpg" alt="이탈리아로마시내워킹투어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">이탈리아·로마</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">63</span>
                    </div>
                  </div>
                  <h3 class="card_title">로마 시내 워킹투어 (반나절) 알고봐야 감탄하는 로마여행</h3>
                  <div class="card_bot">
                    <div class="card_review">
                      <span class="card_review_sign">리뷰5.0</span><span class="card_review_count">21</span>
                    </div>
                    <div>
                      <span class="card_price">30,000 원</span><span class="card_price_std">1인</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>
        </ul>
        <a href="#" id="tour_btn1" class="card_prev">이전</a>
        <a href="#" id="tour_btn2" class="card_next">다음</a>
      </section>


      <section class="trv_info">
        <h2 class="slide_title">어디로 갈까?</h2>

        <ul id="info_slide" class="card_slide">
          <li>
            <div class="card info1">
              <a href="#" class="block">
                <img src="images/travelinfo_image01.jpg" alt="프랑스파리로맨틱박물관">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">프랑스·파리</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">132</span>
                    </div>
                  </div>
                  <h3 class="card_title">로맨틱 박물관</h3>
                  <p class="card_cont">낭만적인 파리에서 로맨틱 박물관을 체험해보세요</p>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div class="card info2">
              <a href="#" class="block">
                <img src="images/travelinfo_image02.jpg" alt="체코프라하마리오네트체험공방">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">체코·프라하</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">1</span>
                    </div>
                  </div>
                  <h3 class="card_title">마리오네트 체험공방</h3>
                  <p class="card_cont">프라하에서 즐기는 공방체험!
                    마리오네트 인형을 직접 만들어봐요!</p>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div class="card info3">
              <a href="#" class="block">
                <img src="images/travelinfo_image03.jpg" alt="미국뉴욕슬립노모어">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">미국·뉴욕</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">2134</span>
                    </div>
                  </div>
                  <h3 class="card_title">슬립 노 모어</h3>
                  <p class="card_cont">보기만하는 공연이 나닌 관객이
                    직접 참여할 수 있는 이색적인 공연!
                    특별한 경험을 원한다면 추천</p>
                </div>
              </a>
            </div>
          </li>

          <li>
            <div class="card info4">
              <a href="#" class="block">
                <img src="images/travelinfo_image04.jpg" alt="헝가리부다페스트국회의사당">
                <div class="card_cont_wrap">
                  <div class="card_top">
                    <span class="card_category">헝가리·부다페스트</span>
                    <div class="card_like">
                      <span class="card_like_sign">좋아요</span><span class="card_like_count">10</span>
                    </div>
                  </div>
                  <h3 class="card_title">부다페스트 국회의사당</h3>
                  <p class="card_cont">부다페스트의 상징적 건물
                    유럽 최고의 야경 포인트!</p>
                </div>
              </a>
            </div>
          </li>
        </ul>
        <a href="#" id="info_btn1" class="card_prev">이전</a>
        <a href="#" id="info_btn2" class="card_next">다음</a>
      </section>


      <div class="sale">
        <h2 class="hide">할인 정보</h2>
        <ul class="sale_slide">
          <li class="sale_cont1 indent"><a href="#">비수기 할인</a>
            <p>일반 시즌 외 비수기에는 더 싸다! '비수기 할인가'로 저렴하게 예약하세요</p>
          </li>
          <li class="sale_cont2 indent"><a href="#">땡처리 할인</a>
            <p>최대30%
              한달 이내에 급하게 남은 할인객실 땡처리!!
              땡처리 할인객실로 저렴하게 예약하세요</p>
          </li>
        </ul>
      </div>


      <div class="cmnt_evnt_wrap">
        <div class="cmnt">
          <h2>커뮤니티</h2>
          <div class="cmnt_menu">
            <ul>
              <li class="cmnt_job cmnt_border"><a href="#">구인·구직</a></li>
              <li class="cmnt_deal"><a href="#">사고·팔고</a></li>
            </ul>
            <a href="#" class="cmnt_more indent">더보기</a>
          </div>
          <div id="cmnt_job_list" class="cmnt_list">
            <ul>
              <li><a href="#"><span class="cmnt_list_date">2022-09-21</span> [구인] 프랑스 파리 몽통통 파리 한인 민박에서 함께 할 가족을
                  구합니다.</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-19</span> [구인] 파리 넘버투 민박 숙식 제공 스텝 모집합니다.</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-18</span> [구인] 프라하 한인민박 도브리프라하에서 스텝 구합니다.</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-14</span> [구직] 23년 2월부터 최소 6개월간 영어권 국가 스텝 지원합니다:)</a>
              </li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-13</span> [구직] 22살 휴학생 (장기근무가능) 구직합니다</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-13</span> [구인] 프랑스 파리 넘버투 민박 파트타임 아르바이트 구합니다</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-11</span> [구인] 러브크로아티아에서 유럽에서 함께 일할분을
                  찾습니다.(상시모집중)</a></li>
            </ul>
          </div>

          <div id="cunt_deal_list" class="cmnt_list displaynone">
          <ul>
              <li><a href="#"><span class="cmnt_list_date">2022-09-21</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-19</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-18</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-14</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-13</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-13</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
              <li><a href="#"><span class="cmnt_list_date">2022-09-11</span> 내용을 길게 쓰자 머라쓰지 내용내용내용내용내용내용내용내용더써야되네</a></li>
            </ul>
          </div>
        </div>

        <div class="evnt">
          <h2>이벤트</h2>
          <div class="evnt_pagination">
            <span id="evnt_page" class="evnt_page"><span id="evnt_now_page"></span>/<span
                id="evnt_total_page"></span></span></span>
            <a href="#" class="evnt_prev indent">이전</a>
            <a href="#" class="evnt_next indent">다음</a>
            <a href="#" class="evnt_stop indent">일시정지</a>
            <a href="#" class="evnt_play indent">재생</a>
          </div>
          <ul class="evnt_slide">
            <li class="evnt_cont1 indent"><a href="#">숙소이벤트</a>
              <p>여러 숙소에서 진행하는 다양한 이벤트를 확인해보세요</p>
            </li>
            <li class="evnt_cont2 indent"><a href="#">숙소쿠폰</a>
              <p>숙소에서 제공하는 다양한 쿠폰을 확인해보세요!
                해당 숙소 예약시 사용 가능</p>
            </li>
          </ul>
        </div>
      </div>


      <div class="app">
        <h2 class="hide">앱 다운로드</h2>
        <p>여행중에도 민다앱을 통해 언제 어디서든지 정보를 쉽게 찾아보세요.</p>
        <a href="#" class="app_apple indent">애플 앱스토어 바로가기</a>
        <a href="#" class="app_gogle indent">구글 플레이스토어 바로가기 </a>
      </div>

      <div class="award_wrap">
        <div class="award">
          <h2 class="hide">수상 내역</h2>
          <div class="award1">
            <img src="./images/award01.png" alt="2016 스마트웹 어워드 코리아 로고">
            <p class="award_txt_wrap">
              <span class="award_txt1">2016 스마트웹 어워드 코리아</span><br>
              <span class="award_txt2">인터넷서비스분야 대상 수상</span>
            </p>
          </div>

          <div class="award2">
            <img src="./images/award02.png" alt="한국소비자 평가 로고">
            <p class="award_txt_wrap">
              <span class="award_txt1">2017 한국소비자 평가 1위</span><br>
              <span class="award_txt2">해외여행부문</span>
            </p>

          </div>

          <div class="award3">
            <img src="./images/award03.png" alt="2018 스마트웹 어워드 코리아 로고">
            <p class="award_txt_wrap">
              <span class="award_txt1">2018 스마트앱 어워드 코리아</span><br>
              <span class="award_txt2">여행/관광분야 최우수상</span>
            </p>
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