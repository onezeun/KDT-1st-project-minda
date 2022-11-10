-- 일반회원 USER
CREATE TABLE user (
  u_idx INT AUTO_INCREMENT PRIMARY KEY,
  u_email VARCHAR(50) NOT NULL,
  u_pwd VARCHAR(20) NOT NULL,
  u_name VARCHAR(30) NOT NULL,
  u_nickname VARCHAR(15) NOT NULL,
  u_phone VARCHAR(20) NOT NULL,
  u_marketing CHAR(1),
  u_img LONGBLOB DEFAULT 'http://localhost/KDT-1st-project-minda/user/profilephoto/default_profile.png',
  reg_date DATETIME
);

-- USER 회원가입 INSERT 쿼리
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('$u_email', '$u_pwd', '$u_name', '$u_nickname', '$u_phone', '$u_marketing', '$reg_date');

INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('admin', '0000', '관리자', '관리자닉네임', '01000000000', 'Y', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트1', '1234', '이름1', '닉네임1', '01011111111', 'Y', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트2', '1234', '이름2', '닉네임2', '01022222222', 'N', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트3', '1234', '이름3', '닉네임3', '01033333333', 'Y', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트4', '1234', '이름4', '닉네임4', '01044444444', 'N', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트5', '1234', '이름5', '닉네임5', '01055555555', 'Y', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트6', '1234', '이름6', '닉네임6', '01066666666', 'N', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트7', '1234', '이름7', '닉네임7', '01077777777', 'Y', now());
INSERT INTO user(u_email, u_pwd, u_name, u_nickname, u_phone, u_marketing, reg_date) VALUES('테스트8', '1234', '이름8', '닉네임8', '01088888888', 'N', now());



-- 파트너회원
CREATE TABLE partner_user (
  p_idx INT AUTO_INCREMENT PRIMARY KEY,
  u_idx INT,
  p_name VARCHAR(20) NOT NULL,
  p_biznum INT NOT NULL,
  p_tel VARCHAR(20) NOT NULL,
  FOREIGN KEY (u_idx) REFERENCES user (u_idx) ON DELETE CASCADE
);

INSERT INTO partner_user(u_idx, p_name, p_biznum, p_tel) VALUES('$u_idx', '$p_name', '$p_biznum', '$p_tel');

INSERT INTO partner_user(u_idx, p_name, p_biznum, p_tel) VALUES(1, '관리자', 123456789, '0236669999');
INSERT INTO partner_user(u_idx, p_name, p_biznum, p_tel) VALUES(7, '테스트7 숙소', 123456789, '023339999');
INSERT INTO partner_user(u_idx, p_name, p_biznum, p_tel) VALUES(8, '테스트8 숙소', 123456789, '0270707070');

-- 일반 회원 중 파트너로 가입되어 있는 사람들 조회
SELECT partner_user.u_idx, partner_user.p_idx, user.u_email, user.u_name, user.u_img, partner_user.p_name FROM partner_user JOIN user ON user.u_idx = partner_user.u_idx;
SELECT user.u_idx, partner_user.p_idx, user.u_email, user.u_pwd, user.u_name, user.u_img, partner_user.p_name FROM user LEFT OUTER JOIN partner_user ON user.u_idx = partner_user.u_idx where u_email='테스트3';

-- 예약 RESERVATION
create table reservation (
  res_idx INT AUTO_INCREMENT PRIMARY KEY,
  ldg_idx INT,
  u_idx INT,
  res_name VARCHAR(30) NOT NULL,
  res_phone VARCHAR(20) NOT NULL,
  res_email VARCHAR(50) NOT NULL,
  res_gender CHAR(1) NOT NULL,
  res_checkin DATE NOT NULL,
  res_checkout DATE NOT NULL,
  res_time DATETIME NOT NULL,
  res_nop INT NOT NULL,
  res_date DATE NOT NULL,
  res_state VARCHAR(20) NOT NULL,
  total_price INT NOT NULL,
  FOREIGN KEY (ldg_idx) REFERENCES lodging (ldg_idx),
  FOREIGN KEY (u_idx) REFERENCES user (u_idx)
);

-- 결제 PAYMENT
create table payment (
  pay_idx INT AUTO_INCREMENT PRIMARY KEY,
  res_idx INT,
  pay_date DATE NOT NULL,
  pay_method VARCHAR(20) NOT NULL,
  FOREIGN KEY (res_idx) REFERENCES reservation (res_idx)
);

-- 좋아요 LIKE
create table like_table (
  ldg_idx INT,
  u_idx INT,
  FOREIGN KEY (ldg_idx) REFERENCES lodging (ldg_idx),
  FOREIGN KEY (u_idx) REFERENCES user (u_idx)
);

-- 숙소 LODGING
create table lodging (
  ldg_idx INT AUTO_INCREMENT PRIMARY KEY,
  p_idx INT,
  ldg_name VARCHAR(50) NOT NULL,
  ldg_addr VARCHAR(100) NOT NULL,
  ldg_tel VARCHAR(20) NOT NULL,
  ldg_info TEXT,
  ldg_maxnop INT NOT NULL,
  toilet INT NOT NULL,
  shower INT NOT NULL,
  FOREIGN KEY (p_idx) REFERENCES partner_user (p_idx)
);

-- 숙소 첨부 파일
create table lodging_file (
  l_file_idx INT AUTO_INCREMENT PRIMARY KEY,
  l_file_name VARCHAR(255),
  ldg_idx INT,
  FOREIGN KEY (ldg_idx) REFERENCES lodging (ldg_idx),
);

-- 숙소 시설 LODGING_FACILITY
create table lodging_facility (
  ldg_idx INT,
  dormitory TINYINT(1),
  privateroom TINYINT(1),
  condo TINYINT(1),
  womenonly TINYINT(1),
  wifi TINYINT(1),
  kitchen TINYINT(1),
  elevator TINYINT(1),
  locker TINYINT(1),
  parking TINYINT(1),
  breakfast TINYINT(1),
  lunch TINYINT(1),
  dinner TINYINT(1),
  FOREIGN KEY (res_idx) REFERENCES reservation (res_idx)
);

-- 객실 ROOM
create table room (
  r_idx INT AUTO_INCREMENT PRIMARY KEY,
  ldg_idx INT,
  r_name VARCHAR(50) NOT NULL,
  r_price INT NOT NULL,
  r_type VARCHAR(10) NOT NULL,
  r_nop INT NOT NULL,
  r_minimum INT,
  r_unisex VARCHAR(5) NOT NULL,
  FOREIGN KEY (ldg_idx) REFERENCES lodging (ldg_idx)
);

-- 객실 첨부 파일
create table room_file (
  r_file_idx INT AUTO_INCREMENT PRIMARY KEY,
  r_file_name VARCHAR(255),
  r_idx INT,
  FOREIGN KEY (r_idx) REFERENCES room (r_idx),
);

-- 리뷰 REVIEW
create table review (
  rv_idx INT AUTO_INCREMENT PRIMARY KEY,
  u_idx INT,
  ldg_idx INT,
  rv_score INT NOT NULL,
  rv_content TEXT NOT NULL,
  FOREIGN KEY (ldg_idx) REFERENCES lodging (ldg_idx),
  FOREIGN KEY (u_idx) REFERENCES user (u_idx)
);

-- 커뮤니티 COMMUNITY
create table community (
  cmm_idx INT AUTO_INCREMENT PRIMARY KEY,
  u_idx INT,
  cmm_title VARCHAR(20) NOT NULL,
  cmm_date DATE NOT NULL,
  cmm_content TEXT NOT NULL,
  category VARCHAR(5) NOT NULL,
  view_cnt INT DEFAULT 0,
  FOREIGN KEY (u_idx) REFERENCES user (u_idx)
);

-- 커뮤니티 댓글 COMMUNITY_COMMENT
create table community_comment (
  co_idx INT AUTO_INCREMENT PRIMARY KEY,
  u_idx INT,
  cmm_idx INT,
  co_content TEXT NOT NULL,
  co_date DATE NOT NULL,
  FOREIGN KEY (u_idx) REFERENCES user (u_idx),
  FOREIGN KEY (cmm_idx) REFERENCES community (cmm_idx)
);