<?php

namespace App\Constants;

class Message
{
    // Auth messages
    const REGISTER_SUCCESS = 'Đăng ký thành công!';
    const LOGIN_SUCCESS = 'Đăng nhập thành công!';
    const LOGOUT_SUCCESS = 'Đăng xuất thành công!';
    const LOGIN_FAILED = 'Email hoặc mật khẩu không đúng.';
    const UNAUTHORIZED = 'Bạn chưa đăng nhập.';
    const FORBIDDEN = 'Bạn không có quyền truy cập.';

    // Validation messages
    const VALIDATION_ERROR = 'Dữ liệu không hợp lệ.';
    const REQUIRED_FIELD = 'Trường này là bắt buộc.';
    const EMAIL_INVALID = 'Email không hợp lệ.';
    const PASSWORD_MIN = 'Mật khẩu phải có ít nhất :min ký tự.';
    const PASSWORD_CONFIRMED = 'Mật khẩu xác nhận không khớp.';
    const EMAIL_EXISTS = 'Email này đã được sử dụng.';

    // General messages
    const SUCCESS = 'Thành công!';
    const ERROR = 'Có lỗi xảy ra.';
    const NOT_FOUND = 'Không tìm thấy dữ liệu.';
    const SERVER_ERROR = 'Lỗi máy chủ. Vui lòng thử lại sau.';
}

