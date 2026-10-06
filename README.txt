HỆ THỐNG TRA CỨU KIẾN THỨC PHÁP LUẬT GIAO THÔNG

1. Công nghệ
- PHP 8+
- MySQL
- HTML/CSS

2. Cài đặt bằng XAMPP
- Copy thư mục "he_thong_tra_cuu_phap_luat" vào:
  C:\xampp\htdocs\
- Mở XAMPP và bật Apache + MySQL.
- Vào phpMyAdmin:
  http://localhost/phpmyadmin
- Chọn Import -> chọn database.sql -> Import.
- Mở:
  http://localhost/he_thong_tra_cuu_phap_luat/

3. Chức năng
- index.php: trang chủ.
- search.php: tra cứu theo từ khóa/câu hỏi.
- documents.php: danh sách văn bản.
- document.php: xem chi tiết văn bản.
- questions.php: kho câu hỏi - trả lời.
- keyphrases.php: danh sách keyphrase.
- config.php: kết nối MySQL.

4. Ý tưởng "ngữ nghĩa đơn giản"
Ví dụ người dùng nhập:
"nón bảo hiểm xe máy"

Hệ thống:
- Chuẩn hóa chữ thường.
- Xác định "nón bảo hiểm" là từ đồng nghĩa của "mũ bảo hiểm".
- Xác định "xe máy" liên quan đến "mô tô".
- Tìm các từ/cụm từ trong câu hỏi và dữ liệu văn bản.
- Mỗi kết quả được cộng điểm.
- Sắp xếp kết quả theo điểm từ cao xuống thấp.

5. Lưu ý dữ liệu
Dữ liệu câu hỏi và nội dung trong database là dữ liệu minh họa phục vụ đồ án, không dùng cho mục đích giáo dục và giảng dạy.
Khi sử dụng thực tế phải đối chiếu văn bản pháp luật chính thức và tình trạng hiệu lực mới nhất.
Thông tin về lĩnh vực giao thông được tham khảo từ nguồn: "https://thuvienphapluat.vn/" và một số nguồn khác.


5. PHẦN AI - TF-IDF + COSINE SIMILARITY

Phiên bản nâng cấp sử dụng:
- TF (Term Frequency): tần suất xuất hiện của từ.
- IDF (Inverse Document Frequency): mức độ quan trọng của từ trong toàn bộ dữ liệu.
- TF-IDF = TF × IDF.
- Cosine Similarity: tính độ tương đồng giữa câu hỏi của người dùng và từng bản ghi.

Luồng xử lý:
Người dùng nhập câu hỏi
→ chuẩn hóa văn bản
→ tách từ
→ loại bỏ một số stop-word
→ mở rộng từ đồng nghĩa
→ tính TF-IDF
→ tính Cosine Similarity
→ xếp hạng
→ hiển thị câu hỏi và văn bản pháp luật phù hợp nhất.

Ưu điểm:
- Không cần cài Python.
- Không cần API AI bên ngoài.
- Chạy trực tiếp trên PHP + MySQL + XAMPP.
- Có thuật toán AI rõ ràng để trình bày trong báo cáo.

6. SO SÁNH VỚI PHIÊN BẢN CŨ

Phiên bản cũ:
- Tìm chuỗi/từ khóa.
- Cộng điểm thủ công khi tìm thấy từ đồng nghĩa.

Phiên bản mới:
- Biểu diễn dữ liệu bằng vector TF-IDF.
- Tính Cosine Similarity.
- Xếp hạng dựa trên độ tương đồng.
- Vẫn giữ từ đồng nghĩa để hỗ trợ truy vấn tiếng Việt.
