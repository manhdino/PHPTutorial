<?php

/** What is session?
 * Session chính là phiên làm việc của người dùng 
 *  Session trong PHP được lưu trên Server (Trong thư mục tạm được thiết lập trong file php.ini)
 *  Khi trình duyệt đóng, Session sẽ bị huỷ

 * KHỞI TẠO SESSION
 *   Để sử dụng được session trong PHP cần phải chạy hàm session_start() trước
 * Cú pháp tạo session: $_SESSION[$name] = $value
 *  Trong đó:
 *$_SESSION: Biến siêu toàn cục của PHP lưu tất cả session (Biến này là mảng)
 *  $name: Tên session cần tạo
 * $value: Giá trị session cần tạo (Chấp nhận mảng)

 * XOÁ SESSION
 * Để xoá session chỉ định, sử dụng cú pháp: unset($_SESSION[$name])
 * Để xoá tất cả session, sử dụng cú pháp: session_destroy()
 * Vd: Khi chúng ta vào trang login và login thành công rồi(Lúc này
 * Server lưu sesstion là tên của user ) và khi sang trang khác(Home) thì sẽ ko cần phải kiểm tra login nữa 
 */
if (!defined('_INCODE')) die('Access denied...');
//echo 'includes/session';

//Ham gan session
function set_session($key, $value)
{
    if (session_id()) {
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
}

//Ham doc session
function get_session($key = '')
{
    if (empty($key)) {
        return $_SESSION;
    } else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
    return false;
}

//Ham xoa session
function remove_session($key = '')
{
    if (empty($key)) {
        session_destroy();
        return true;
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    }
    return false;
}

//Ham gan flash data
function set_flash_data($key, $value)
{
    $key = 'flash_' . $key;
    return set_session($key, $value);
}

//Ham doc flash data
function get_flash_data($key = '')
{
    $key = 'flash_' . $key;
    $data = get_session($key);
    remove_session($key);
    return $data;
}
