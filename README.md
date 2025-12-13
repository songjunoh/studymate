# 📚 StudyMate

PHP + MySQL 기반 웹응용 과제 프로젝트입니다.  
회원 관리, 게시판, 방명록, 댓글, 좋아요, 관리자 페이지 기능을 포함합니다.

---

## 🔧 개발 환경
- Apache (XAMPP)
- PHP 8.x
- MySQL (MariaDB)
- HTML / CSS / JavaScript
- GitHub

---

## 📌 주요 기능

### 👤 회원
- 회원가입 / 로그인 / 로그아웃
- 마이페이지 (이메일 / 비밀번호 수정)

### 📝 게시판
- 글 작성 / 수정 / 삭제
- 댓글 작성 / 삭제
- 좋아요 기능
- 페이징 처리

### 📖 방명록
- 로그인 사용자 작성
- 관리자 삭제 가능

### 🛠 관리자 페이지
- 회원 관리
- 게시글 관리
- 댓글 관리
- 통계 대시보드

---

## 📂 프로젝트 구조
studymate/
├── admin/
│ ├── admin_dashboard.php
│ ├── admin_users.php
│ ├── admin_board.php
│ └── admin_comments.php
├── lib/
│ └── db.php (gitignore)
├── css/
│ └── style.css
├── uploads/
│ └── .gitkeep
├── index.php
├── login.php
├── signup.php
├── board.php
├── board_view.php
├── guestbook.php
└── README.md

---

## 🌐 브라우저 접속 방법

1. **XAMPP 실행**
   - Apache, MySQL 실행

2. 프로젝트 위치
C:\xampp\htdocs\studymate

3. 브라우저에서 접속
http://localhost/studymate
4. 관리자 페이지 접속 (관리자 계정 로그인 후)
http://localhost/studymate/admin/admin_dashboard.php
---

## ⚠️ 주의사항
- `lib/db.php`는 GitHub에 포함되지 않습니다.
- DB 테이블은 직접 생성해야 합니다.

---

## ✍️ 작성자
- 송준오
- 웹응용 과제

