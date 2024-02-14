- Vì các file auth.php, validation.php, pagination.php là các file mặc định của laravel nên ko nên vẫn giữ lại các file này.
(xóa or move đi sẽ gây lỗi linh tinh khi phát sinh các exception, authen, ...)
Trong mỗi file đó, nếu muốn thêm các mess cho các phần admin_epay, affiliate, merchant thì trong mỗi file mình thêm mess vào từng key tương ứng là được.

- Các phần khác thì mn cứ vào từng file admin_epay.php, affiliate.php, merchant.php để define các key tương ứng theo chức năng.

- Khi tạo key thì mn note tên key vào file này luôn:
https://bapjsc.sharepoint.com/:x:/s/Slash/EQ1OjfPJIm1BoSpzm-Cc_mgBTTsbpglPWoD34X0yBjfHSg?e=BTnZpE
