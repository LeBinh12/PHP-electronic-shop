<?php

require_once './models/User.php';
require_once './models/UserReports.php';
require_once './controllers/BaseController.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Respect\Validation\Validator as v;


class UserController extends BaseController
{
    private $userModel;
    private $userReportModel;
    private $jwtConfig;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->userReportModel = new UserReports();
        $this->jwtConfig = include   './config/jwt.php';
    }

    public function getById($id)
    {
        return $this->userModel->find($id);
    }

    public function register($data)
    {

        $rules = [
            'FullName' => v::stringType()->length(3, 50)
                ->setTemplate("Họ tên phải từ 3 đến 50 ký tự"),

            'Email' => v::email()->notEmpty()
                ->setTemplate("Email không hợp lệ hoặc để trống"),

            'Phone' => v::phone()->notEmpty()
                ->setTemplate("Số điện thoại không hợp lệ"),

            'Address' => v::stringType()->length(5, 255)
                ->setTemplate("Địa chỉ phải từ 5 đến 255 ký tự"),

            'password' => v::stringType()->length(6, 32)
                ->setTemplate("Mật khẩu phải từ 6 đến 32 ký tự"),
        ];
        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'message'  => $this->validator->error()
            ];
        }


        // if ($this->userModel->existsByName($data['Email'])) {
        //     return ['success' => false, 'message' => 'Email đã tồn tại'];
        // }

        $data['PasswordHash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['CreatedAt'] = date('Y-m-d H:i:s');
        unset($data['password']);
        $id = $this->userModel->insert($data);
        return ['success' => true, 'id' => $id];
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['PasswordHash'])) {
            return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
        }

        $checkReportUser = $this->userReportModel->getLatestByUserId($user['id']);
        if ($checkReportUser) {
            if ($checkReportUser['banned_until'] > date('Y-m-d H:i:s')) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản của bạn đã bị khóa',
                    'report' => $checkReportUser
                ];
            }
        }

        $now = time();
        $token = [
            'iss' => $this->jwtConfig['issuer'],
            'aud' => $this->jwtConfig['audience'],
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
            'data' => [
                'id' => $user['id'],
                'email' => $user['Email'],
                'name' => $user['FullName'],
                'phone' => $user['Phone'],
                'address' => $user['Address']
            ]
        ];
        $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
        return ['success' => true, 'token' => $jwt];
    }

    public function getCurrentUser()
    {
        if (!isset($_SESSION['jwt'])) {
            return null;
        }
        try {
            $decoded = JWT::decode($_SESSION['jwt'], new Key($this->jwtConfig['secret_key'], 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
    public function validateToken($authHeader)
    {
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return null;
        }
        $jwt = $matches[1];
        try {
            $decoded = JWT::decode($jwt, new Key($this->jwtConfig['secret_key'], 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }

    public function updateProfile($id, $data, $isUser)
    {
        $rules = [
            'FullName' => v::optional(v::stringType()->length(3, 50))
                ->setTemplate("Họ tên phải từ 3 đến 50 ký tự"),

            'Email' => v::optional(v::email())
                ->setTemplate("Email không hợp lệ"),

            'Phone' => v::optional(v::phone())
                ->setTemplate("Số điện thoại không hợp lệ"),

            'Address' => v::optional(v::stringType()->length(5, 255))
                ->setTemplate("Địa chỉ phải từ 5 đến 255 ký tự"),
        ];

        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'message' => $this->validator->error()
            ];
        }

        if (!empty($data['password'])) {
            if (!v::stringType()->length(6, 32)->validate($data['password'])) {
                return ['success' => false, 'message' => 'Mật khẩu phải từ 6 đến 32 ký tự'];
            }
            $data['PasswordHash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $data['UpdateAt'] = date('Y-m-d H:i:s');

        $result = $this->userModel->update($id, $data);
        if ($isUser) {
            if ($result) {
                $userById = $this->userModel->find($id);
                $now = time();
                $token = [
                    'iss' => $this->jwtConfig['issuer'],
                    'aud' => $this->jwtConfig['audience'],
                    'iat' => $now,
                    'nbf' => $now,
                    'exp' => $now + 3600,
                    'data' => [
                        'id' => $userById['id'],
                        'email' => $userById['Email'],
                        'name' => $userById['FullName'],
                        'phone' => $userById['Phone'],
                        'address' => $userById['Address']
                    ]
                ];
                $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
                return ['success' => true, 'token' => $jwt];
            } else {
                return ['success' => false, 'message' => "Lỗi cập nhật"];
            }
        }

        if ($result) {
            return ['success' => true, 'message' => "Cập nhật thông tin người dùng thành công!"];
        } else {
            return ['success' => false, 'message' => "Lỗi cập nhật"];
        }
    }


    public function getPagination($limit, $offset, $keyword)
    {
        return $this->userModel->getFilteredUsers($limit, $offset, $keyword);
    }

    public function countUser($keyword)
    {
        return $this->userModel->countUser($keyword);
    }
}
