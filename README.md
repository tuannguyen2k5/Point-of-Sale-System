# Team1: Hệ thống quản lý các điểm bán hàng: Point of Sale System

-   Là một hệ thống quản lý kho / hàng tồn kho dựa trên laravel (php) cho phép bạn quản lý hàng tồn kho, bán hàng, mua hàng, khách hàng, hóa đơn, thanh toán ...

-   Cập nhật thông tin kho hàng của bạn, mua hàng và xem thông tin bán hàng từ mọi nơi, mọi lúc. Cho dù bạn đang điều hành một doanh nghiệp nhỏ hay một doanh nghiệp lớn, Point of Sale System là giải pháp bạn cần để quản lý hàng tồn kho, mua hàng, bán hàng - tất cả trong một ứng dụng

# Các công nghệ sử dụng:

-   Laravel 8
-   PHP 7.4
-   MySQL 5.7
-   Docker 20.10.8
-   Apache 2

# Cách cài đặt (trên Windows)

-   Sau khi pull source về, chạy docker compose:

```
docker-compose up -d --buld
```

-   Vào container chứa source để chạy composer cho project

```
docker exec -it team1-app bash
```

-   Cài composer cho project

```
composer install
```

-   Database được lưu trữ, quản lý bằng adminer tại địa chỉ https://localhost:2221
-   Kết nối database với project, project chạy tại địa chỉ https://localhost:2229
