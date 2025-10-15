# 🧱 MVC Project with Twig Modules Manager

## 📌 Giới thiệu
Dự án PHP theo kiến trúc **MVC**, sử dụng **Twig** làm template engine và có hệ thống **quản lý module** (bật/tắt, thay đổi vị trí hiển thị trong trang web).

---

## ⚙️ 1. Cài đặt môi trường

### Yêu cầu
- PHP 7.4+  
- Composer (trình quản lý gói PHP)  
- Apache hoặc XAMPP  

---

## 🧰 2. Cài đặt Twig

### Bước 1: Khởi tạo Composer

Mở **Terminal** trong thư mục dự án (trong PHPStorm hoặc VS Code):

```bash
composer init
```
### Bước 2: Cài đặt Twig

Sau khi composer.json được tạo xong, chạy lệnh:

composer require "twig/twig:^3.0"

---

## 🧰 3. Cấu hình

### Bước 1: Cấu hình VirtualHost trong httpd-vhosts.conf (thường nằm trong xampp\apcache\conf\extra\httpd-vhosts.conf)

Mở Notepad++ và mở file như đường link trên:

```bash
<VirtualHost *:80>
    ServerAdmin admin@thuctap.local
    DocumentRoot "D:/thuctap"
    ServerName thuctap.local
    ServerAlias www.thuctap.local

    <Directory "D:/thuctap">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Chỉnh sửa lại đường dẫn cho đúng với nơi đặt file

### Bước 2:  Cấu hình file hosts ( địa chỉ file là C:\Windows\System32\drivers\etc\hosts)

Mở Notepad++ và mở file như đường link trên:

```bash
127.0.0.1 thuctap.local
```
---
