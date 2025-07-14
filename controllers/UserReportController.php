<?php

require_once './models/UserReports.php';

class UserReportController
{
    private $userReportModel;

    public function __construct()
    {
        $this->userReportModel = new UserReports();
    }

    public function getById($id)
    {
        return $this->userReportModel->find($id);
    }

    public function getByUserId($userId)
    {
        return $this->userReportModel->getLatestByUserId($userId);
    }

    public function add($data)
    {
        $report = $this->userReportModel->insert($data);
        return [
            'success' => true,
            'message' => 'Báo cáo người dùng thành công!',
            'report' => $report
        ];
    }
}
