# REGULAR EXPRESSION

## Regular Expression(Regex) là gì?

Regular Expression (Biểu thức chính quy) được dùng để xử lý chuỗi nâng cao thông qua biểu thức riêng của nó.

Nguyên tắc hoạt động của Regex sẽ so khớp dựa vào các Pattern (Khuôn mẫu) thay vì so sánh dựa vào chuỗi cố định

Pattern trong các ngôn ngữ lập trình đều giống nhau (Ngoại trừ modifier, dấu phân cách,...)

Trong PHP, Regex được xử lý thông qua các hàm: preg_match(), preg_match_all(), preg_replace(),...

##Regular Expression làm được những gì?

Regular Expression có tác dụng chính là xử lý chuỗi gồm:

- **So khớp**: Khớp chuỗi thoả mãn điều kiện của khuôn mẫu (pattern)
- **Cắt chuỗi**: Lấy ra nội dung chuỗi theo pattern
- **Thay thế**: Thay thế chuỗi theo pattern

##Website kiểm tra Regular Expression: https://regex101.com

##Các ký hiệu cơ bản Regular Expression

**Cú pháp pattern Regex**

```php
$pattern = '/pattern string/modifier';
```

Trong đó:

- Dấu phân cách / có thể được thay thế thành các ký tự khác: @, #, ~, !,...
- Để thực hiện so khớp Pattern, cần sử dụng hàm: preg_match()

**Cú pháp hàm preg_match()**

```php
preg_match($pattern, $subject, $matches);
```

Trong đó:

- $pattern: Biểu thức so khớp (Khuôn mẫu)
- $subject: Chuỗi cần khớp
- $matches: Tham biến dùng để lấy kết quả so khớp (Chính là chuỗi được khớp với biểu thức)
- Nếu kết quả so khớp là chính xác, hàm này sẽ trả về giá trị 1 (Ngược lại sẽ trả về 0)

**Các ký hiệu cơ bản trong Regex**

- ^: So khớp đầu chuỗi
- $: So khớp cuối chuỗi
- [min-max]: A-Z, a-z, 0-9 (Viết trong dấu [] sẽ là điều kiện hoặc)
- [list_char]: Các ký tự muốn tìm (Chấp nhận ký tự đặc biệt)
- {min,max}: Độ dài từ min đến max
- {min,}: Độ dài >=min
- {max}: Độ dài cố định = max
- {0,max}: Độ từ <=max

**Các ký hiệu viết tắt trong Regex**

- `*`: {0,}
- `+`: {1,}
- `?`: {0,1}
- `.`: Đại diện cho tất cả ký tự (Bao gồm cả ký tự đặc biệt, khoảng trắng,...)
- `\d`: Chữ số bất kỳ ~ [0-9]
- `\D`: Ký tự bất kỳ không phải là chữ số (ngược với \d) ~ [^0-9]
- `\w`: Ký tự từ a-z, A-Z, _ hoặc 0-9 ~ [a-zA-Z0-9_]
- `\W`: Ngược lại với \w (nghĩa là các ký tự không thuộc các khoảng: a-z, A-Z, dấu gạch dưới (_) hoặc 0-9) ~[^a-zA-Z0-9_]
- `\s`: Khoảng trắng (space)
- `\S`: Ký tự bất kỳ không phải là khoảng trắng

**Nguyên tắc xử lý khi gặp các ký hiệu trong Regex**

Thêm ký tự escape (\\) vào trước ký hiệu của Regex

- Dấu chấm (.)
- Dấu cộng (+)
- Dấu sao (\*)
- Dấu hỏi (?)
- Dấu ngoặc vuông ([ hoặc ])
- Dấu phân cách (/, #, ~,...)
- Dấu mũ (^)
- Dấu đô la ($)

**Phủ định (NOT) và Hoặc (OR) trong Regex**

Khi làm việc với Regex, nếu muốn phủ định 1 biểu thức => Bổ sung ký tự ^ vào trước biểu thức

Ví dụ:

```php
$pattern = '/[^0-9]+/'; //Không phải là số

$pattern = '/[^A-Z0-9a-z]/'; //Không phải là chữ hoa và chữ thường và số
```

Trong nhiều trường hợp, nếu muốn kiểm tra nhiều trường hợp => Sử dụng ký hiệu |

Ví dụ:

```php
$pattern = '/php|backend/';
```

Khi kết hợp với biểu thức khác cần gom nhóm trong dấu ngoặc () để cho kết quả chính xác

```php
$pattern = '/(php|backend)[0-9]+/';
```

##Cắt chuỗi Regular Expression

Để cắt chuỗi trong Regex, chúng ta sử dụng hàm `preg_match()` hoặc `preg_match_all()` với tham biến

```php
preg_match($pattern, $subject, $matches);

echo '<pre>';
print_r($matches);
echo '</pre>';
```

hoặc

```php
preg_match_all($pattern, $subject, $matches);

echo '<pre>';
print_r($matches);
echo '</pre>';
```

Tham biến `$matches` sẽ trả về 1 mảng tương ứng với giá trị match được

##Capturing Group trong Regular Expression

- Capturing Group là kỹ thuật cắt các biểu thức con (Được nhóm trong cặp ngoặc "(" và ")"
- Kết quả của biểu thức này sẽ được đưa vào tham biến $matches
- Thứ tự các Capturing Group được tính từ trái qua phải

Ví dụ: Lấy link ảnh trong thẻ `<img>`

##Greedy trong Regular Expression

Greedy là tình trạng tham lam khi sử dụng dấu . để đại diện cho các ký tự

Để khắc phục tình trạng Greedy, chỉ cần thêm ký tự ? vào sau độ dài của dấu .

##None Capturing Group

None Capturing Group ngược lại với Capturing Group, có nghĩa sẽ không cắt nội dung trong cặp ngoặc đơn vào tham biến $matches

Kỹ thuật này trên thực tế không được sử dụng nhiều, tuy nhiên nó vẫn cần thiết trong nhiều trường hợp và tránh bị rối khi debug tham biến $matches

Cú pháp:

```php
$pattern = '/(?:pattern_string)/';
```

###Thay thế trong Regular Expression

- Thay thế trong Regex có nghĩa là kỹ thuật thay thế biểu thức Regex thành chuỗi (Có thể có đối sánh chuỗi hoặc không)
- Để thay thế chuỗi trong Regex, chúng ta cần sử dụng hàm `preg_replace()`

Cú pháp:

```php
$result = preg_replace($pattern, $replace, $subject);
```

Trong đó:

- $pattern: Biểu thức Regex cần tìm kiếm để thay thế
- $replace: Chuỗi cần thay thế
- $subject: Chuỗi cần tìm kiếm

Lưu ý:

- Hàm này sẽ trả về chuỗi sau khi đã thay thế
- Hàm này chỉ thay thế tất cả kết quả tìm được. Nếu muốn giới hạn tham số lượng vào tham số thứ 4

##Đối sánh chuỗi trong Regular Expression

- Đối sánh chuỗi là kỹ thuật được áp dụng trong việc thay thế và có sử dụng Capturing Group
- Đối sánh chuỗi sẽ giữ nguyên giá trị của biểu thức tìm được sang chuỗi cần thay thế (Tham số $replace)
- Để áp dụng đối sánh chuỗi, chúng ta cần sử dụng các ký hiệu: $1, $2, $3 tương ứng với các Capturing Group bên $pattern

Ví dụ:

```php
$content = preg_replace('/(0\d{9})/', '<a href="tel:$1">$1</a>', $content);
```

Qua ví dụ này ta thấy toàn bộ nội dung của $pattern sẽ được đối sánh qua tham số $replace để thêm thẻ HTML `<a>`

##Look Around trong Regular Expression

Look Around là nhóm kỹ thuật xử lý Regex nâng cao và rất hữu ích khi xử lý chuỗi phức tạp

Look around là nhóm không chiếm giữ (non capturing group) dùng để so khớp dựa vào những gì nó tìm thấy trước (look ahead) và sau (look behind) một mẫu

Look Around bao gồm:

- Positive lookahead: Cú pháp (?=ABC)
- Negative lookahead: Cú pháp (?!ABC)
- Positive lookbehind: Cú pháp (?<=ABC)
- Negative lookbehind: Cú pháp (?<!ABC)

```php

$content = 'unicode academy academy unicode';

```

**Tình huống 1**: Lấy chữ `academy` mà có chữ `academy` đứng sau nó

Pattern viết như sau:

```php
$pattern = '/academy(?=\sacademy)/';
```

**Tình huống 2**: Lấy chữ `academy` mà không có chữ `academy` đứng phía sau nó

Pattern viết như sau:

```php
$pattern = '/academy(?!\sacademy)/;
```

**Tình huồng 3**: Lấy chữ `academy` mà có chữ `unicode` đứng phía trước nó

Pattern viết như sau:

```php
$pattern = '/(?<=unicode\s)academy/';
```

**Tình huống 5**: Lấy chữ `academy` mà không có chữ `unicode` đứng phía trước nó

Pattern viết như sau:

```php
$pattern = '/(?<!unicode\s)academy/';
```

##Modifier trong Regex

- Modifier là thông số cấu hình cho chuỗi pattern
- Mỗi modifier có những tác dụng nhất định và có thể kết hợp nhiều modifier trong 1 pattern
- Modifier được đặt phía sau dấu phân cách
- Regex có rất nhiều modifier, trong phạm vi bài học chúng ta chỉ học những modifier phổ biến

**Cú pháp:**

```php
$pattern = '/pattern string/modifier';
```

**Danh sách modifier thường gặp:**

- i: Không phân biệt chữ hoa, chữ thường (Thường được sử dụng kiểm tra url, mã html,...)
- u: Hỗ trợ pattern Tiếng Việt
- s: Tìm kiếm cả chuỗi xuống dòng (single line)
- m: Tìm kiếm đầu chuỗi (^) và cuối chuỗi ($) trên 1 dòng (multi line)
