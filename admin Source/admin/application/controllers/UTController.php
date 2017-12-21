<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class UTController extends CI_Controller {


    public function __construct()
    {
        parent::__construct();   
        $this->load->model('LoginModel');
        $this->load->model('IndexModel');
        $this->load->model('ChangePasswordModel');
        $this->load->model('ForgotPasswordModel');
        $this->load->model('GameDetailModel');
        $this->load->model('ManagerModel');
        $this->load->model('EditManagerModel');
        $this->load->model('CultureGameModel');
        // $this->load->model('GameDetailModel');
        // $this->load->model('GameDetailModel');
        // $this->load->model('GameDetailModel');
       
        $this->load->library('unit_test');

    }  
    /**
     *
     * @return [type] [description]
     */
    public function index()
    {

    }     

    /**
     * [getNotiContent description]
     * @return [type] [description]
     */
    public function unitTest() 
    {
        
        /**
         * [Login page unitest]
         */
        // $this->unit->run($this->LoginModel->checkLogin('tranhongquan.94@gmail.com', md5('1234@abcA')), $expected = true,'Kiểm tra admin đăng nhập đúng.');

        // $this->unit->run($this->LoginModel->checkLogin('vinhnguyenvan1995@gmail.com', md5('1234@abcA')), $expected = false,'Kiểm tra đăng nhập sai vì không đủ quyền đăng nhập.');   

        // $this->unit->run($this->LoginModel->checkLogin('test1@gmail.com', md5('1234@abcA')), $expected = false,'Kiểm tra manager đã bị block không thể đăng nhập.');

        // $this->unit->run($this->LoginModel->checkLogin('test2@gmail.com', md5('1234@abcA')), $expected = true,'Kiểm tra manager đăng nhập thành công.');

        /**
         * [Home page unitest]
        */

        // $this->unit->run($this->IndexModel->getNumberMember(), $expected = 'is_int','Kiểm tra load số lượng người chơi');

        // $this->unit->run($this->IndexModel->getNumberMonthMember(), $expected = 'is_string','Kiểm tra load số lượng người chơi theo tháng');

        // $this->unit->run($this->IndexModel->getNumberSystemGame(), $expected = 'is_int','Kiểm tra load số lượng game Truyền Thống.');

        // $this->unit->run($this->IndexModel->getNumberYNGame(), $expected = 'is_int','Kiểm tra load số lượng game YN.');

        // $this->unit->run($this->IndexModel->getNumberMCGame(), $expected = 'is_int','Kiểm tra load số lượng game MC.');

        // $this->unit->run($this->IndexModel->getNumberEachMonth(), $expected = 'is_array','Kiểm tra load số lượng người chơi mỗi tháng.');
        
        // $this->unit->run($this->IndexModel->getMemberOderByPoint(), $expected = 'is_array','Kiểm tra load số lượng người chơi có nhiều point nhất.');

        // $this->unit->run($this->IndexModel->getYNGame(), $expected = 'is_array','Kiểm tra load YN game.');

        // $this->unit->run($this->IndexModel->getMCGame(), $expected = 'is_array','Kiểm tra load MC game.');


        /**
         * ChangePasswordModel
         */
        // $this->unit->run($this->ChangePasswordModel->getOldPassword(3), $expected = 'is_string','Kiểm tra load mật khẩu.');

        // $this->unit->run($this->ChangePasswordModel->updatePassword(3, md5('1234@abcA')), $expected = true,'Kiểm tra update mật khẩu.');

        /**
         * [$expected ForgotPasswordModel]
         */
        // $this->unit->run($this->ForgotPasswordModel->checkRole('tranhongquan.94@gmail.com'), $expected = true,'Kiểm tra quyền (admin or manager) đổi mật khẩu đúng');

        // $this->unit->run($this->ForgotPasswordModel->checkRole('vinhnguyenvan1995@gmail.com'), $expected = false,'Kiểm tra quyền (admin or manager) đổi mật khẩu sai');

        // $this->unit->run($this->ForgotPasswordModel->updatePass('tranhongquan.94@gmail.com', md5('1234@abcA')), $expected = true,'Kiểm tra quyền email (admin or manager) đổi mật khẩu đúng');

        /**
         * [$expected ForgotPasswordModel]
         */
        // $this->unit->run($this->GameDetailModel->getGameDetail('YN', 71), $expected = 'is_object','Kiểm tra load game YN');

        // $this->unit->run($this->GameDetailModel->getGameDetail('MC', 46), $expected = 'is_object','Kiểm tra load game YN');

        // $this->unit->run($this->GameDetailModel->getOwner(46), $expected = 'is_object','Kiểm tra load người tạo game');

        // $this->unit->run($this->GameDetailModel->getJoinerList('MC', 46), $expected = 'is_array','Kiểm tra load người tham gia game MC');

        // $this->unit->run($this->GameDetailModel->getJoinerList('YN', 71), $expected = 'is_array','Kiểm tra load người tham gia game YN');

        // $this->unit->run($this->GameDetailModel->getGameDetail('MC', 46), $expected = 'is_object','Kiểm tra load game YN');

        /**
         * [$expected ManagerModel]
         */
        $this->unit->run($this->ManagerModel->getInfoById(3), $expected = 'is_object','Kiểm tra load thông tin người quản lý');

        /**
         * [$expected EditManagerModel]
         */
        $this->unit->run($this->EditManagerModel->getInfoById(3), $expected = 'is_object','Kiểm tra load game YN');

        $this->unit->run($this->EditManagerModel->updateUserInfo(3, 'hotaru', '+84962575594', 'Thanh Miện - Hải Dương'), $expected = true,'Kiểm tra update thông tin người quản lý');

        /**
         * CultureGameModel
         */
        $this->unit->run($this->CultureGameModel->getAllCultureGame(), $expected = true,'Kiểm tra load toàn bộ game truyền thống');

        /**
         * CultureGameModel
         */
        $this->unit->run($this->CultureGameModel->getAllCultureGame(), $expected = true,'Kiểm tra load toàn bộ game truyền thống');



        $this->load->view('UnitTest');
    }
}
