CREATE DATABASE IF NOT EXISTS phapluat
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE phapluat;

DROP TABLE IF EXISTS keyphrases;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS documents;

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    issuer VARCHAR(255) NOT NULL,
    effective_date DATE,
    content TEXT NOT NULL,
    keywords TEXT
);

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    keywords TEXT,
    source VARCHAR(255)
);

CREATE TABLE keyphrases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phrase VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    synonyms TEXT
);

INSERT INTO documents(title,type,issuer,effective_date,content,keywords) VALUES
('Luật Trật tự, an toàn giao thông đường bộ số 36/2024/QH15',
 'Luật','Quốc hội','2025-01-01',
 'Luật quy định về trật tự, an toàn giao thông đường bộ; quyền, nghĩa vụ và trách nhiệm của người tham gia giao thông; phương tiện tham gia giao thông; người điều khiển phương tiện; chỉ huy, điều khiển giao thông và các nội dung liên quan.',
 'giao thông đường bộ, người tham gia giao thông, giấy phép lái xe, phương tiện, an toàn giao thông'),

('Nghị định 165/2024/NĐ-CP',
'Nghị định','Chính phủ','2025-01-01',
'Nghị định quy định chi tiết, hướng dẫn thi hành một số điều của Luật Đường bộ và Điều 77 Luật Trật tự, an toàn giao thông đường bộ.',
'Luật Đường bộ, giao thông đường bộ, kết cấu hạ tầng, phương tiện, vận tải'),

('Nghị định 241/2026/NĐ-CP',
'Nghị định','Chính phủ','2026-07-01',
'Nghị định sửa đổi, bổ sung một số điều của Nghị định 165/2024/NĐ-CP về quy định chi tiết, hướng dẫn thi hành một số điều của Luật Đường bộ và Điều 77 Luật Trật tự, an toàn giao thông đường bộ.',
'sửa đổi, Luật Đường bộ, giao thông đường bộ, kết cấu hạ tầng, vận tải'),

('Nghị định 236/2026/NĐ-CP',
'Nghị định','Chính phủ','2026-07-01',
'Nghị định sửa đổi, bổ sung một số điều của Nghị định 151/2024/NĐ-CP về quy định chi tiết một số điều và biện pháp thi hành Luật Trật tự, an toàn giao thông đường bộ.',
'sửa đổi, giao thông đường bộ, trật tự an toàn giao thông, thi hành luật'),

('Thông tư 47/2024/TT-BGTVT',
'Thông tư','Bộ Giao thông vận tải','2025-01-01',
'Thông tư quy định trình tự, thủ tục kiểm định, miễn kiểm định lần đầu cho xe cơ giới, xe máy chuyên dùng; chứng nhận an toàn kỹ thuật và bảo vệ môi trường đối với xe cơ giới cải tạo; kiểm định khí thải xe mô tô, xe gắn máy.',
'kiểm định, xe cơ giới, xe máy, khí thải, an toàn kỹ thuật, bảo vệ môi trường'),

(
'Nghị định 01/2024/NĐ-CP',
'Nghị định','Chính phủ','2024-01-01',
'Nghị định sửa đổi, bổ sung một số điều của các quy định về quản lý và bảo vệ kết cấu hạ tầng giao thông đường bộ.',
'kết cấu hạ tầng, đường bộ, bảo vệ đường bộ, quản lý đường bộ'),

('Nghị định 151/2024/NĐ-CP',
'Nghị định','Chính phủ','2025-01-01',
'Nghị định quy định chi tiết một số điều và biện pháp thi hành Luật Trật tự, an toàn giao thông đường bộ.',
'trật tự an toàn giao thông, giao thông đường bộ, thi hành luật'),

('Nghị định 168/2024/NĐ-CP',
'Nghị định','Chính phủ','2025-01-01',
'Nghị định quy định xử phạt vi phạm hành chính về trật tự, an toàn giao thông trong lĩnh vực giao thông đường bộ; trừ điểm và phục hồi điểm giấy phép lái xe.',
'xử phạt, vi phạm giao thông, trừ điểm, giấy phép lái xe, đường bộ'),

('Nghị định 238/2026/NĐ-CP',
'Nghị định','Chính phủ','2026-08-15',
'Nghị định sửa đổi, bổ sung một số điều của Nghị định 168/2024/NĐ-CP về xử phạt vi phạm hành chính trong lĩnh vực giao thông đường bộ; trừ điểm và phục hồi điểm giấy phép lái xe.',
'sửa đổi, xử phạt, vi phạm giao thông, trừ điểm, giấy phép lái xe'),

('Thông tư 17/2012/TT-BGTVT',
'Thông tư','Bộ Giao thông vận tải','2013-01-01',
'Thông tư ban hành Quy chuẩn kỹ thuật quốc gia về báo hiệu đường bộ, quy định về hệ thống báo hiệu đường bộ.',
'báo hiệu đường bộ, biển báo, đèn tín hiệu, giao thông'),

('Nghị định 168/2024/NĐ-CP',
 'Nghị định','Chính phủ','2025-01-01',
 'Nghị định quy định xử phạt vi phạm hành chính về trật tự, an toàn giao thông trong lĩnh vực giao thông đường bộ; trừ điểm và phục hồi điểm giấy phép lái xe.',
 'xử phạt, vi phạm giao thông, giấy phép lái xe, trừ điểm, đường bộ'),

('Nghị định 151/2024/NĐ-CP',
 'Nghị định','Chính phủ','2025-01-01',
 'Nghị định quy định chi tiết một số điều và biện pháp thi hành Luật Trật tự, an toàn giao thông đường bộ.',
 'quy định chi tiết, giao thông đường bộ, thi hành luật'),

('Nghị định 238/2026/NĐ-CP',
 'Nghị định','Chính phủ','2026-08-15',
 'Nghị định sửa đổi, bổ sung một số điều của Nghị định 168/2024/NĐ-CP về xử phạt vi phạm hành chính trong lĩnh vực giao thông đường bộ; trừ điểm và phục hồi điểm giấy phép lái xe.',
 'sửa đổi, xử phạt, giao thông đường bộ, trừ điểm, giấy phép lái xe');

INSERT INTO questions(question,answer,keywords,source) VALUES
('Giấy phép lái xe hạng B có thời hạn bao lâu?',
 'Theo Luật Trật tự, an toàn giao thông đường bộ, giấy phép lái xe hạng B có thời hạn 10 năm kể từ ngày cấp.',
 'giấy phép lái xe, bằng lái, hạng B, thời hạn',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Xe máy không đội mũ bảo hiểm có bị phạt không?',
 'Có. Người điều khiển và người ngồi trên xe mô tô, xe gắn máy phải tuân thủ quy định về an toàn giao thông, trong đó có quy định liên quan đến việc đội mũ bảo hiểm. Mức xử phạt cần đối chiếu văn bản xử phạt đang có hiệu lực tại thời điểm tra cứu.',
 'xe máy, mô tô, mũ bảo hiểm, nón bảo hiểm, xử phạt',
 'Luật Trật tự, an toàn giao thông đường bộ và văn bản xử phạt liên quan'),

('Vượt đèn đỏ có vi phạm pháp luật giao thông không?',
 'Có. Người tham gia giao thông phải chấp hành hiệu lệnh của đèn tín hiệu giao thông. Mức xử phạt cụ thể phụ thuộc loại phương tiện và hành vi vi phạm theo quy định xử phạt hiện hành.',
 'vượt đèn đỏ, đèn tín hiệu, xe máy, ô tô, xử phạt',
 'Luật Trật tự, an toàn giao thông đường bộ; Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

('Uống rượu bia rồi lái xe có được không?',
 'Người điều khiển phương tiện tham gia giao thông phải tuân thủ quy định về nồng độ cồn. Khi tra cứu mức xử phạt cụ thể cần xác định loại phương tiện và mức nồng độ cồn theo văn bản hiện hành.',
 'nồng độ cồn, rượu bia, lái xe, ô tô, xe máy',
 'Luật Trật tự, an toàn giao thông đường bộ; Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),
 
 ('Người ngồi sau xe máy có phải đội mũ bảo hiểm không?',
 'Có. Người ngồi trên xe mô tô, xe gắn máy cũng thuộc đối tượng phải tuân thủ quy định về mũ bảo hiểm khi tham gia giao thông.',
 'xe máy, người ngồi sau, mũ bảo hiểm, đội mũ',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

 ('Đi xe máy có được sử dụng điện thoại không?',
 'Người điều khiển phương tiện phải tuân thủ các quy định bảo đảm an toàn khi sử dụng điện thoại và thiết bị liên lạc trong quá trình tham gia giao thông.',
 'xe máy, điện thoại, lái xe, an toàn giao thông',
 'Luật Trật tự, an toàn giao thông đường bộ; Nghị định 168/2024/NĐ-CP'),

('Ô tô có phải thắt dây an toàn không?',
 'Người điều khiển và người ngồi trên xe ô tô phải tuân thủ quy định về sử dụng dây an toàn trong những trường hợp pháp luật quy định.',
 'ô tô, dây an toàn, an toàn giao thông',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

 ('Đi xe máy vượt quá tốc độ cho phép có bị xử phạt không?',
 'Có. Vi phạm quy định về tốc độ có thể bị xử phạt. Mức xử phạt cụ thể cần căn cứ loại phương tiện, mức độ vi phạm và văn bản xử phạt đang có hiệu lực.',
 'xe máy, tốc độ, quá tốc độ, xử phạt',
 'Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

 ('Ô tô chạy quá tốc độ có bị phạt không?',
 'Có. Người điều khiển ô tô phải tuân thủ giới hạn tốc độ áp dụng trên tuyến đường. Vi phạm có thể bị xử lý theo quy định hiện hành.',
 'ô tô, tốc độ, quá tốc độ, xử phạt',
 'Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

('Có được vượt xe ở mọi nơi không?',
 'Không. Việc vượt xe phải tuân thủ các điều kiện và trường hợp được phép theo quy tắc giao thông đường bộ, đồng thời phải bảo đảm an toàn.',
 'vượt xe, vượt phương tiện, quy tắc giao thông',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Khi chuyển làn có cần báo hiệu không?',
 'Có. Khi chuyển làn, người điều khiển phương tiện cần quan sát, báo hiệu và bảo đảm an toàn trước khi thực hiện.',
 'chuyển làn, xi nhan, báo hiệu, làn đường',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Xe máy có được đi vào làn dành cho ô tô không?',
 'Người điều khiển phương tiện phải đi đúng phần đường, làn đường dành cho phương tiện theo quy định và hệ thống báo hiệu trên đường.',
 'xe máy, ô tô, làn đường, phần đường',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Khi gặp đèn vàng người điều khiển xe phải làm gì?',
 'Người tham gia giao thông phải chấp hành tín hiệu đèn giao thông theo quy định. Trường hợp cụ thể cần căn cứ trạng thái tín hiệu và vị trí của phương tiện khi tín hiệu thay đổi.',
 'đèn vàng, đèn tín hiệu, đèn giao thông',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Khi gặp xe cứu hỏa đang làm nhiệm vụ phải làm gì?',
 'Người tham gia giao thông phải thực hiện việc nhường đường cho xe ưu tiên trong các trường hợp pháp luật quy định.',
 'xe cứu hỏa, xe ưu tiên, nhường đường',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Xe cứu thương có được quyền ưu tiên không?',
 'Xe cứu thương thuộc nhóm phương tiện được pháp luật quy định về quyền ưu tiên khi thực hiện nhiệm vụ và đáp ứng các điều kiện theo quy định.',
 'xe cứu thương, xe ưu tiên, quyền ưu tiên',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Khi xảy ra tai nạn giao thông cần làm gì?',
 'Khi xảy ra tai nạn giao thông, người liên quan cần thực hiện các biện pháp bảo đảm an toàn, hỗ trợ người bị nạn và thực hiện trách nhiệm theo quy định pháp luật.',
 'tai nạn giao thông, va chạm, người bị nạn',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Có được tự ý bỏ đi sau khi gây tai nạn giao thông không?',
 'Không nên tự ý rời khỏi hiện trường. Người liên quan đến tai nạn cần thực hiện các nghĩa vụ theo quy định và hỗ trợ xử lý hậu quả của vụ tai nạn.',
 'tai nạn giao thông, rời hiện trường, trách nhiệm',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Điều khiển xe khi có nồng độ cồn có bị xử lý không?',
 'Có. Người điều khiển phương tiện phải tuân thủ quy định pháp luật về nồng độ cồn khi tham gia giao thông. Mức xử lý cụ thể phụ thuộc trường hợp và loại phương tiện.',
 'nồng độ cồn, rượu bia, lái xe, xử phạt',
 'Luật Trật tự, an toàn giao thông đường bộ; Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

('Uống bia rồi điều khiển xe máy có vi phạm không?',
 'Người điều khiển xe máy phải tuân thủ quy định về nồng độ cồn khi tham gia giao thông. Nếu thuộc trường hợp vi phạm thì có thể bị xử lý theo quy định hiện hành.',
 'uống bia, xe máy, nồng độ cồn, xử phạt',
 'Luật Trật tự, an toàn giao thông đường bộ; Nghị định 168/2024/NĐ-CP'),

('Giấy phép lái xe bị trừ điểm trong trường hợp nào?',
 'Một số hành vi vi phạm giao thông thuộc trường hợp áp dụng cơ chế điểm giấy phép lái xe có thể dẫn đến việc bị trừ điểm theo quy định.',
 'giấy phép lái xe, GPLX, trừ điểm, vi phạm giao thông',
 'Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

('Điểm giấy phép lái xe có được phục hồi không?',
 'Pháp luật có quy định về cơ chế phục hồi điểm giấy phép lái xe trong những trường hợp đáp ứng điều kiện theo quy định.',
 'giấy phép lái xe, điểm GPLX, phục hồi điểm',
 'Nghị định 168/2024/NĐ-CP và văn bản sửa đổi'),

('Khi dừng xe có cần chú ý đến vị trí dừng không?',
 'Có. Người điều khiển phương tiện phải lựa chọn vị trí dừng phù hợp, không gây cản trở hoặc nguy hiểm cho người và phương tiện khác.',
 'dừng xe, dừng đỗ, vị trí dừng, an toàn giao thông',
 'Luật Trật tự, an toàn giao thông đường bộ 36/2024/QH15'),

('Hàng hóa chở trên xe máy có cần chằng buộc không?',
 'Có. Hàng hóa khi vận chuyển phải được sắp xếp và chằng buộc phù hợp, bảo đảm an toàn và không gây nguy hiểm hoặc cản trở giao thông.',
 'xe máy, chở hàng, hàng hóa, chằng buộc',
 'Luật Trật tự, an toàn giao thông đường bộ và quy định liên quan')
 ;

INSERT INTO keyphrases(phrase,category,synonyms) VALUES
('Giấy phép lái xe','Giấy tờ','bằng lái, bằng lái xe, GPLX'),
('Mũ bảo hiểm','An toàn','nón bảo hiểm, đội mũ, đội nón'),
('Xe máy','Phương tiện','mô tô, xe hai bánh'),
('Ô tô','Phương tiện','xe hơi, xe con'),
('Vượt đèn đỏ','Hành vi vi phạm','vượt đèn tín hiệu, không chấp hành đèn tín hiệu'),
('Nồng độ cồn','Hành vi vi phạm','rượu bia, uống rượu, uống bia'),
('Tốc độ','Quy tắc giao thông','quá tốc độ, chạy quá nhanh'),
('Dừng đỗ','Quy tắc giao thông','dừng xe, đỗ xe, dừng đỗ'),
('Xử phạt','Chế tài','phạt tiền, xử lý vi phạm, mức phạt'),
('Giao thông đường bộ','Khái niệm','trật tự an toàn giao thông, an toàn giao thông');
