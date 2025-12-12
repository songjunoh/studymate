# 📚 StudyMate

PHP와 MySQL을 활용한 웹 응용 과제용 커뮤니티 웹사이트입니다.  
회원 관리, 게시판, 댓글, 관리자 기능을 포함한 풀스택 웹 애플리케이션입니다.

---

## 🛠 개발 환경
- PHP 8.x
- MySQL (MariaDB)
- Apache (XAMPP)
- HTML / CSS
- GitHub

---

## ✨ 주요 기능

### 👤 회원 기능
- 회원가입 / 로그인 / 로그아웃
- 마이페이지 (이메일, 비밀번호 수정)
- 권한 관리 (user / admin)

### 📝 게시판
- 게시글 작성 / 수정 / 삭제
- 게시글 조회수
- 페이징 처리
- 좋아요 기능
- 댓글 작성 / 삭제
- 댓글 페이징

### 📖 방명록
- 로그인 사용자 방명록 작성
- 관리자 방명록 삭제

### 🛡 관리자 페이지
- 관리자 전용 대시보드
- 회원 관리 (삭제, 권한 변경)
- 게시글 관리
- 댓글 관리
- 통계 정보 제공
  - 전체 회원 수
  - 전체 게시글 수
  - 전체 댓글 수
  - 오늘 가입 / 오늘 게시글 수

---

## 📂 프로젝트 구조
studymate/
├─ admin/ # 관리자 페이지
│ ├─ admin_dashboard.php
│ ├─ admin_users.php
│ ├─ admin_board.php
│ ├─ admin_comments.php
│ └─ ...
├─ css/
│ └─ style.css
├─ lib/
│ └─ db.php
├─ uploads/ # 파일 업로드
├─ index.php
├─ login.php
├─ signup.php
├─ board.php
├─ guestbook.php
└─ ...


## ⚠️ 보안
- DB 정보는 `.gitignore`로 제외
- 비밀번호는 `password_hash()` 사용

## 📌 과제 목적
PHP와 MySQL을 활용한 웹 애플리케이션 CRUD 및 세션 처리 학습

---

## 🗄 데이터베이스 구조 (요약)

### users
| 컬럼 | 설명 |
|----|----|
| id | 사용자 ID |
| username | 아이디 |
| password | 암호화 비밀번호 |
| email | 이메일 |
| role | 권한 (user / admin) |
| regdate | 가입일 |

### board
| 컬럼 | 설명 |
|----|----|
| id | 게시글 ID |
| title | 제목 |
| content | 내용 |
| username | 작성자 |
| views | 조회수 |
| regdate | 작성일 |

### comments
| 컬럼 | 설명 |
|----|----|
| id | 댓글 ID |
| board_id | 게시글 ID |
| username | 작성자 |
| content | 내용 |
| regdate | 작성일 |

---

## 🚀 실행 방법
1. XAMPP 실행 (Apache, MySQL)
2. `htdocs`에 프로젝트 복사
3. MySQL에 DB 생성 후 테이블 생성
4. `lib/db.php` DB 정보 설정
5. 브라우저에서 접속  

http://localhost/studymate

---

## 👨‍💻 제작자
- 송준오
- 웹응용 과제 프로젝트
