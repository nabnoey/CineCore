# CineCore — ระบบแคตตาล็อกภาพยนตร์ (Laravel)

โปรเจกต์นี้เป็นเว็บแอปสำหรับแสดงรายการภาพยนตร์และจัดการข้อมูลภาพยนตร์ ฝั่งผู้ใช้ทั่วไปจะเห็นรายการและรายละเอียดภาพยนตร์ ส่วนผู้ดูแล (Admin) สามารถแก้ไขข้อมูลภาพยนตร์ได้ ระบบใช้ Laravel + Vite และผสมผสาน Bootstrap 5, Tailwind CSS/DaisyUI สำหรับ UI

## คุณสมบัติหลัก
- แสดงรายการภาพยนตร์เป็นการ์ดแบบกริด พร้อมภาพโปสเตอร์และลิงก์ไปหน้ารายละเอียด
- ระบบล็อกอิน/สมัครสมาชิก และเมนูผู้ใช้ผ่าน Navbar Dropdown
- หน้าผู้ดูแลแก้ไขข้อมูลภาพยนตร์ (ชื่อ เรื่องย่อ โปสเตอร์ URL เทรลเลอร์ URL และหมวดหมู่หลายค่า) พร้อม Select2
- สไตล์หลักใช้ Bootstrap 5 ผสม Tailwind CSS/DaisyUI และปรับแต่งตัวแปร SCSS สำหรับ Navbar/Dropdown
- จัดการ asset ด้วย Vite (`@vite`) และมีสคริปต์ fallback ให้ Navbar Dropdown ทำงานแม้ JS ไม่ถูกโหลดจาก Vite

## โครงสร้างไฟล์ที่เกี่ยวข้อง (บางส่วน)
- `resources/views/layouts/app.blade.php:23` — โครงหน้า Layout หลัก มี Navbar/โครงสร้างพื้นฐาน และเรียก `@vite(['resources/sass/app.scss', 'resources/js/app.js'])`
- `resources/views/layouts/app.blade.php:59` — รายการเมนูผู้ใช้แบบ Dropdown (แสดงเมื่อผู้ใช้ล็อกอิน)
- `resources/views/layouts/app.blade.php:101` — สคริปต์ fallback/initialization สำหรับ Bootstrap Dropdown ให้ใช้งานได้แม้ JS จาก Vite ไม่โหลด
- `resources/views/movies.blade.php:1` — หน้ารายการภาพยนตร์ (ตัวอย่างหน้าแบบ standalone ใช้ Tailwind/DaisyUI)
- `resources/views/admin/movies/edit.blade.php:1` — หน้าแก้ไขภาพยนตร์สำหรับผู้ดูแล มีฟอร์มฟิลด์และ Select2 สำหรับหมวดหมู่หลายค่า
- `resources/js/app.js:1` — จุดเริ่ม JS ของ Vite (import `./bootstrap`)
- `resources/js/bootstrap.js:1` — โหลด Bootstrap JS และตั้งค่า Axios (รวม Popper ผ่านแพ็กเกจ `bootstrap`)
- `resources/sass/app.scss:1` — โหลดตัวแปร SCSS, Bootstrap และ Tailwind CSS/DaisyUI
- `resources/sass/_variables.scss:21` — ตัวแปรปรับโทนสี Navbar/Dropdown
- `package.json:1` — กำหนด devDependencies และสคริปต์ `vite`

## ฟีเจอร์/การทำงานโดยละเอียด
- Navbar & ผู้ใช้
  - แสดงเมนู Login/Register เมื่อยังไม่ล็อกอิน
  - เมื่อเข้าสู่ระบบ จะแสดงชื่อผู้ใช้และรูปโปรไฟล์ (ถ้ามี) ในเมนู Dropdown
  - ปุ่มใน Dropdown:
    - ไปแก้ไขโปรไฟล์ `route('profile.edit')`
    - ออกจากระบบ `route('logout')` (ส่งฟอร์ม POST แบบป้องกัน CSRF)
- Dropdown ทำงานอย่างไร
  - ใช้ `data-bs-toggle="dropdown"` ตามมาตรฐาน Bootstrap 5
  - ถ้า Vite/JS ไม่โหลด ระบบมีสคริปต์ fallback ใน `resources/views/layouts/app.blade.php:101` ที่จะ:
    - โหลด `bootstrap.bundle.min.js` จาก CDN อัตโนมัติ (ถ้ายังไม่มี `window.bootstrap`)
    - เรียก `new bootstrap.Dropdown(...)` ให้ทุกตัวที่ระบุ `data-bs-toggle="dropdown"`
    - มี manual fallback เสริม: คลิกที่ `#navbarDropdown` จะสลับ class `show` ของ `.dropdown-menu` เพื่อให้ใช้งานได้แม้ CDN ถูกบล็อก
- หน้าแสดงรายการภาพยนตร์
  - โครง UI เป็นกริดการ์ด พร้อมภาพโปสเตอร์ ชื่อเรื่อง และลิงก์ไป `GET /movies/{id}`
- หน้าแก้ไขภาพยนตร์ (Admin)
  - ฟอร์มแก้ไขฟิลด์: Title, Description, Poster Image URL, Trailer URL, Categories (หลายค่า)
  - ใช้ Select2 เพื่อเลือกหมวดหมู่หลายค่า โหลดผ่าน CDN (`jquery` + `select2`)
  - เส้นทางที่ใช้งาน: `route('admin.movies.update', id)`, ลิงก์กลับ `route('admin.movies.index')`

## เทคโนโลยีที่ใช้
- Backend: Laravel (PHP)
- Frontend: Bootstrap 5, Tailwind CSS 4, DaisyUI
- Assets: Vite (`@vite`), SCSS
- JS libs: Axios, Select2, SweetAlert2
- Dev tooling: `sass`, `vite`

## การติดตั้งและรันโครงการ (แนะนำ)
1. ติดตั้งเครื่องมือพื้นฐาน
   - PHP 8.x, Composer, Node.js LTS, npm
2. ติดตั้ง dependencies
   - รัน `composer install`
   - รัน `npm install`
3. ตั้งค่าแอป
   - คัดลอกไฟล์ `.env.example` เป็น `.env` และตั้งค่า DB/APP_KEY
   - สร้างคีย์ระบบ: `php artisan key:generate`
   - รันไมเกรตฐานข้อมูล: `php artisan migrate` (และ `php artisan db:seed` ถ้ามี seeder)
   - ลิงก์สตอเรจ (ถ้าใช้รูปโปรไฟล์): `php artisan storage:link`
4. รันโหมดพัฒนา
   - รัน Vite: `npm run dev`
   - รันเซิร์ฟเวอร์: `php artisan serve`
5. เปิดเบราว์เซอร์ไปยัง URL ที่แสดง (เช่น `http://127.0.0.1:8000`)

## วิธี build assets สำหรับโปรดักชัน
- รัน `npm run build` แล้วปรับ config ให้เซิร์ฟเวอร์เสิร์ฟไฟล์ที่ build แล้ว (Vite จะดูแลอัตโนมัติเมื่อใช้ `@vite` ใน Blade)

## หมายเหตุสำคัญเกี่ยวกับ Dropdown
- หน้าใดที่ไม่ใช้ Layout หลัก (`@extends('layouts.app')`) จะไม่ดึงสคริปต์ fallback ทำให้ Dropdown ไม่ทำงาน ให้:
  - เปลี่ยนไปใช้ Layout หลัก หรือ
  - เพิ่ม `@vite(['resources/sass/app.scss','resources/js/app.js'])` และคัดลอกสคริปต์ fallback ตอนท้าย `<body>` ของหน้านั้น

## การแก้ปัญหาที่พบบ่อย
- Dropdown ไม่แสดง/ไม่คลิก
  - ตรวจว่าอยู่ในหน้าที่ใช้ `layouts.app` หรือไม่
  - ตรวจว่า asset จาก Vite โหลดสำเร็จ (`app.css`, `app.js`)
  - ดูคอนโซลเบราว์เซอร์ว่ามี error หรือบล็อก CDN/JS หรือไม่
  - รีเฟรชแบบเคลียร์แคช (Ctrl+F5)

## ลิขสิทธิ์
- โปรเจกต์นี้สำหรับการศึกษา/ต่อยอด หากต้องการเผยแพร่ โปรดตรวจสอบนโยบายภายในของคุณ

