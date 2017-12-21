<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
require_once FCPATH .'/vendor/autoload.php';
class UserCT extends CI_Controller {
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$this->load->model('game');
		$this->load->library('unit_test');
	}

	/**
	 * [addUser description]
	 */
	public function home()
	{		
		try {
    		$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);

    		if($user->ROLE_ID == ROLE_USER){

    			if($user->ATTENDANCE == 0){
		            $this->user->updatePoint($user->USER_ID, $user->USER_POINT + REWARD_POINT);
		            $is_update_attendance = $this->user->update_attendance($user->USER_ID);
		            if($is_update_attendance){
		                $data['is_reward'] = true;
		            }
		        }else{
		            $data['is_reward'] = false;
		        }

		        $user = $this->user->getUserById($user->USER_ID);

				$tt_game = $this->game->getGameTT();

				$roomID = $this->user->get_room_by_game_id($tt_game->GAME_ID);
				
				//set sessionUserID
		    	$this->session->set_userdata('sessionUserId', $user->USER_ID);
			    $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);
			    $this->session->set_userdata('session_room', $roomID);

			    //load messsage room chat        
        		$data['messages'] = $this->user->get_messsages_chat($roomID);
        		
			    //Đã đặt cược game truyền thống
		        if($this->game->check_Log_Game_TT($user->USER_ID, $tt_game->GAME_ID)){
		            $data['price_bet_before'] = $this->game->get_price_bet_before($user->USER_ID, $tt_game->GAME_ID);
		        }

				$data['USER_NAME'] = $user->USER_NAME;
				$data['USER_POINT'] = $user->USER_POINT;
		        $data['GAME_TT_CONTENT'] = $tt_game->CONTENT;
		        $data['TT_END_DATE'] = $tt_game->END_DATE;

		        //load game active
                $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
                $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
                $data['top_point'] = $this->user->get_top_point();
                $data['user_id'] = $user->USER_ID;
                $data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
                $data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
                $data['top_users_achievement'] = $this->user->get_user_achievement_before();

				$this->load->view('user/home', $data);		
    		}else{
    			redirect(base_url());
    		}
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
            $this->load->view('errors/error_page');
		}
	}

	/**
	 * [updateUser description]
	 * @param  [type] $USER_CIF [description]
	 * @return [type]           [description]
	 */
	public function updateUser()
	{
		$USER_ID = $this->session->userdata('sessionUserId');	

		if(isset($USER_ID)){
			$USER_NAME = $this->input->post('username');	
			$USER_PHONE = $this->input->post('userphone');	
			$USER_ADDRESS = $this->input->post('useraddress');

			$this->user->updateUser($USER_ID,$USER_NAME,$USER_PHONE,$USER_ADDRESS);	
			echo json_encode("1");
		}else{
			echo json_encode("0");
		}
	}


	/**
	 * [checkUserExist description] Kiểm tra email có tồn tại không (có trung với email google or facebook không) 
	 * rồi add user vào
	 * @return [type] [description]
	 */
	public function checkUserExist()
	{
		if(isset($_POST['email']) && isset($_POST['pass'])){
			$email = $this->input->post('email');
			$pass = $this->input->post('pass');

			//Kiểm tra email tồn tại hay không
			$isExist = $this->user->checkUserExist($email);
	
			//Nếu tồn tại thì xem đã có tài khoản google hay facebook nào đăng nhập chưa
			if($isExist){
				$is_Mail_FB_GG = $this->user->check_Mail_FB_GG($email);
				//email tồn tại và không trùng tài khoản google hay facebook, kiểm tra xem pass có đúng không
				if(!$is_Mail_FB_GG){
					$user = $this->user->getUserByMail($email);
					$pass = md5($pass);
					if(hash_equals($pass,$user->PASSWORD)){
						$userData['USER_EMAIL'] = $email;
						$userData['USER_AVATAR'] = null;
						//set session
						$this->session->set_userdata('userData', $userData);
						$this->session->set_userdata('loggedOther', true);
						
						//email, pass trung khop
						echo json_encode(2);
					}else{
						echo json_encode(0);
					}
				}else{
					echo json_encode(4);
				}
			}else{
				//email chưa có => add user
				$pass = md5($pass);
				$created_date = date("Y-m-d");
				$id = $this->user->add_other_user($email, $pass, $created_date);
				if($id > 0){

					$userData['USER_EMAIL'] = $email;
					$userData['USER_AVATAR'] = null;

					//set session
					$this->session->set_userdata('userData', $userData);
					$this->session->set_userdata('loggedOther', true);
					
					echo json_encode(1);	 
				}else{
					echo json_encode(3);
				}
			}
		}
	}

	/**
	 * Cập nhật lại trạng thái đã xem, lấy nội dung thông báo ra
	 * @return [type] [description]
	 */
	public function update_seen_noti()
	{
		if(isset($_POST['noti_id']) && isset($_POST['game_id']) && isset($_POST['type_id']) && isset($_POST['send_date'])){
			
			$noti_id = $this->input->post('noti_id');
			$game_id = $this->input->post('game_id');
			$type_id = $this->input->post('type_id');
			
			$send_date = $this->input->post('send_date');
			$send_date = new DateTime($send_date);
			$send_date = $send_date->format('Y-m-d H:i:s');

			$userID = $this->session->userdata('sessionUserId');
			
			if($game_id == null || $game_id == "" || $game_id == 'null'){
				//1. Set seen
				$result = $this->user->update_seen_notifi_no_game($noti_id, $userID, $type_id, $send_date);
				$noti_not_seen = $this->user->get_all_noti_not_seen($userID);
				//2.Get content
				$noti_content = $this->user->get_noti_content_no_game($noti_id, $userID, $type_id, $send_date);
			}else{
				//1. Set seen
				$result = $this->user->update_seen_notifi($noti_id, $userID, $game_id, $type_id, $send_date);
				$noti_not_seen = $this->user->get_all_noti_not_seen($userID);
				//2.Get content
				$noti_content = $this->user->get_noti_content($noti_id, $userID, $game_id, $type_id, $send_date);
			}

			if($noti_content){
				echo json_encode(array('noti_content'=>$noti_content, 'noti_not_seen'=>$noti_not_seen));
			}
		}
	}

	/**
	 * Lấy nội dung thông báo
	 * @return [type] [description]
	 */
	public function get_noti_content()
	{
		if(isset($_POST['noti_id']) && isset($_POST['game_id']) && isset($_POST['type_id']) && isset($_POST['send_date'])){
			
			$noti_id = $this->input->post('noti_id');
			$game_id = $this->input->post('game_id');
			$type_id = $this->input->post('type_id');
			
			$send_date = $this->input->post('send_date');
			$send_date = new DateTime($send_date);
			$send_date = $send_date->format('Y-m-d H:i:s');

			$userID = $this->session->userdata('sessionUserId');
			
			if($game_id == null || $game_id == "" || $game_id == 'null'){
				$noti_content = $this->user->get_noti_content_no_game($noti_id, $userID, $type_id, $send_date);
			}else{
				$noti_content = $this->user->get_noti_content($noti_id, $userID, $game_id, $type_id, $send_date);
			}

			if($noti_content){
				echo json_encode(array('noti_content'=>$noti_content));
			}
		}
	}

	/**
	 * [change_password description]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function change_password()
	{
		if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['code'])){
			$email = $this->input->post('email');
			$pass = $this->input->post('pass');
			$code = $this->input->post('code');

			//Kiểm tra lại pass
			// if(preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,15}$', $pass)){
				//kiem tra email xem co phai la email google hay facebook hay khong,
				//neu la email google, fb thi khong co quyen doi mat khau
				$isMail_FB_GG = $this->user->check_Mail_FB_GG($email);				

				if(!$isMail_FB_GG){
					//trung ma code
					if($code === $this->session->userdata('code')){
						//doi mat khau
						$pass = md5($pass);
						$result = $this->user->update_password($email, $pass);
						if($result > 0){
							echo json_encode(1);
						}else{
							//loi he thong
							echo json_encode(2);
						}
					}else{
						//khong trung code
						echo json_encode(0);
					}					
				}else{
					echo json_encode(3);
				}
			// }else{
			// 	echo json_encode(3);
			// }
		}
	}

	/**
	 * [check_mail description]
	 * @return [type] [description]
	 */
	public function send_confirm_code()
	{
		if(isset($_POST['email'])){
			$email = $this->input->post('email');
			$isExist = $this->user->checkUserExist($email);
			//email ton tai
			if($isExist){
				$isMail_FB_GG = $this->user->check_Mail_FB_GG($email);
				if(!$isMail_FB_GG){
					//send mã xác nhận về email
					$code = $this->random_code();
					$this->session->set_userdata('code', $code);
					if($this->sendMail($email, $code)){ //gui thanh cong mail
						echo json_encode(1);
					}else{
						//Loi khi gui mail
						echo json_encode(0);
					}
				}else{
					echo json_encode(3);
				}
			}else{
				//email khong ton tai
				echo json_encode(2);
			}
		}
	}

	/**
	 * [history description]
	 * @return [type] [description]
	 */
	public function history()
	{
		$userID = $this->session->userdata('sessionUserId');
		$user = $this->user->getUserById($userID);
		if($user){

			$data = array();
			$data = $this->load_view_profile($userID, $data);

			$data['USER_NAME'] = $user->USER_NAME;
			$data['USER_POINT'] = $user->USER_POINT;

			//load game active
	        $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
	        $data['top_point'] = $this->user->get_top_point();
	        $data['user_id'] = $user->USER_ID;
	        $data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
	        $data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
			$data['is_history'] = true;

			//data history Chỉ những game có người tham gia mới được lọc
			$data['user_history'] = $this->user->get_user_history($user->USER_ID);
			//->lấy thêm những game mà không có người chơi
			$data['games_no_player'] = $this->user->get_games_no_player($user->USER_ID);

	        //echo 'Dang chuan bi lam';
			$this->load->view('user/history', $data);
			
		}else{
			redirect(base_url());
		}
	}

	/**
	 * [profile description] view profile: history 
	 * @return [type] [description]
	 */
	public function profile()
	{
		$id_user_view = $this->uri->segment(3);
		
		if(isset($_SESSION['sessionUserId'])){

			$userID = $this->session->userdata('sessionUserId');
			$user = $this->user->getUserById($userID);

			$data = array();
	        $data = $this->load_view_profile($id_user_view, $data);

	        $data['USER_NAME'] = $user->USER_NAME;
			$data['USER_POINT'] = $user->USER_POINT;

			//load game active
	        $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
	        $data['top_point'] = $this->user->get_top_point();
	        $data['user_id'] = $user->USER_ID;
	        $data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
	        $data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
	        $data['is_history'] = false;

			$this->load->view('user/history', $data);
			
		}else{
			//guest view profile
			$data = array();
	        $data = $this->load_view_profile($id_user_view, $data);

	        $this->load->view('user/history', $data);
		}
	}

	function load_view_profile($id_user_view, $data)
	{
		$data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
        $data['top_users_achievement'] = $this->user->get_user_achievement_before();

        //data viewer
        $user_view = $this->user->getUserById($id_user_view);
        $data['user_view'] = $this->user->get_user_profile($id_user_view);
        $data['user_view_name'] = $user_view->USER_NAME;
        $data['user_view_point'] = $user_view->USER_POINT;
		$data['user_view_phone'] = $user_view->PHONE_NUMBER;
		$data['user_view_email'] = $user_view->EMAIL;
		$data['user_view_address'] = $user_view->ADDRESS;
		$data['user_avatar'] = $user_view->AVATAR;

		$data['user_view_total_game'] = $this->user->countNumberTotalGame($id_user_view);
		$data['user_view_total_game_win'] = $this->user->countWin($id_user_view);

		return $data;
	}

	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout()
	{
		//delete login status & user info from session
        $this->session->set_userdata('loggedOther', false);
        $this->session->unset_userdata('loggedOther');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('sessionUserId');
        $this->session->sess_destroy();        
        
        redirect(base_url());
	}

	/**
	 * [sendMail description]
	 * @param  [type] $to   [description]
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public function sendMail($to, $code)
	{
		$mail = new PHPMailer(true);
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		$mail->isHTML(true);
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		//Ask for HTML-friendly debug output
		//$mail->Debugoutput = 'html';
		$mail->CharSet = 'UTF-8';
		//Set the hostname of the mail server
		// $mail->Host = 'smtp.gmail.com';
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		// $mail->Port = 25;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "lowhope2017@gmail.com";
		//Password to use for SMTP authentication
		$mail->Password = "hanhphucnhe2509";
		//Set who the message is to be sent from
		$mail->setFrom('lowhope2017@gmail.com', 'Low Hope');
		//Set an alternative reply-to address
		$mail->addReplyTo('lowhope2017@gmail.com', 'Low Hope');
		//Set who the message is to be sent to
		$mail->addAddress($to);
		//Set the subject line
		$mail->Subject = '[LOW HOPE] ĐẶT LẠI MẬT KHẨU';

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		
		$message  = "Chào bạn, <br><br>";
		$message .= "Chúng tôi nhận được yêu cầu đặt lại mật khẩu tại lowhope.com <br><br>";
		$message .= "Đây là mã xác nhận để thực hiện việc đổi mật khẩu của bạn: <strong>";
		$message .= $code;
		$message .= "</strong> <br><br>";
		$message .= "Nếu bạn không yêu cầu đặt lại mật khẩu, có thể là có người khác đã điền nhầm địa chỉ email của bạn, nên bạn có thể bỏ qua email này. <br>";
		$message .= "<hr>";
		$message .= "Chúc bạn sử dụng website vui vẻ, <br><br>";
		$message .= "<strong>LOW HOPE</strong>";

		$mail->Body	= $message;	

		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
		//send the message, check for errors
		if (!$mail->send()) {
			echo 'Message could not be sent.';
    		echo 'Mailer Error: ' . $mail->ErrorInfo;
		    return false;
		} else {
		    return true;
		}
	}

	/**
	 * [random_code description]
	 * @return [type] [description]
	 */
	public function random_code()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    	$pass = array(); //remember to declare $pass as an array
    	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function search()
	{
		$data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
		$data['all_game'] = $this->game->load_all_games();
		$this->load->view('user/search', $data);
	}

	function unit_test_user()
	{
		// $this->unit->run($this->user->updateUser(39,'Vinh Hăm Bẹn', 'Hoàng Mai', '0898989898'), $expected = 1,'Kiểm tra update thông tin người chơi theo id.');
		
		// $this->unit->run($this->user->updateUser(399,'Vinh Hăm Bẹn', 'Hoàng Mai', '0898989898'), $expected = 0,'Kiểm tra update thông tin người chơi không tồn tại theo id.');
		
		// $this->unit->run($this->user->checkUserExist('aa@gmail.com'), $expected = false,'Kiểm tra email người chơi không tồn tại.');
		
		// $this->unit->run($this->user->checkUserExist('duycong2509@gmail.com'), $expected = true,'Kiểm tra email người chơi tồn tại.');
		
		// $this->unit->run($this->user->check_Mail_FB_GG('duycong2509@gmail.com'), $expected = true,'Kiểm tra email người chơi có phải là email google hay facebook đã đăng nhập.');
	 
		// $this->unit->run($this->user->check_Mail_FB_GG('thanhtung24fpt@gmail.com'), $expected = false,'Kiểm tra email người chơi có phải là email google hay facebook đã đăng nhập.');
		
		// $this->unit->run($this->user->getUserByMail('thanhtung24fpt@gmail.com'), $expected = 'is_object','Kiểm tra thành công thông tin người chơi tồn tại qua email.');
		
		// $this->unit->run($this->user->getUserByMail('aaaaa@gmail.com'), $expected = null,'Kiểm tra thành công thông tin người chơi không tồn tại qua email.');
		
		// $this->unit->run($this->user->add_other_user('unit_test_add_user_1@gmail.com', '123a123@A', date("Y-m-d")), $expected = 48,'Kiểm tra thành công thêm mới người chơi vào hệ thống.');
		
		// $this->unit->run($this->user->update_seen_notifi(5, 4, 72, 1, '2017-12-06 16:30:01'), $expected = 1,'Kiểm tra thành công update trạng thái thông báo của người chơi.');
		
		// $this->unit->run($this->user->update_seen_notifi(5, 4, 72, 1, '2017-12-06 16:30:01'), $expected = 0,'Kiểm tra thành công update trạng thái thông báo của người chơi.');
		
		// $this->unit->run($this->user->get_all_noti_not_seen(1), $expected = 4,'Kiểm tra thành công số lượng thông báo chưa đọc.');
		
		// $this->unit->run($this->user->get_all_noti_not_seen(1111), $expected = 0,'Kiểm tra thành công số lượng thông báo chưa đọc.');
		
		// $this->unit->run($this->user->get_noti_content(5, 4, 72, 1, '2017-12-06 16:30:01'), $expected = 'is_object', 'Kiểm tra thành công lấy nội dung của thông báo.');
		
		// $this->unit->run($this->user->get_noti_content(555, 4, 72, 1, '2017-12-06 16:30:01'), $expected = null, 'Kiểm tra thành công lấy nội dung của thông báo không tồn tại.');
	
		// $this->unit->run($this->user->update_password('tungntse03924@fpt.edu.vn', '123a123@A'), $expected = 1, 'Kiểm tra việc update password của người chơi thành công.');
		
		// $this->unit->run($this->user->update_password('ldccc@gmail.com', '123a123@A'), $expected = 0, 'Kiểm tra việc update password của người chơi không tôn tại thành công.');
		
		// $this->unit->run($this->sendMail('vinhnguyenvan1995@gmail.com', '1234567A'), $expected = 0, 'Kiểm tra việc gửi email thành công.');
		

		

		
		

		

		

		$this->load->view('user/unitTestUser');
	}
}

/* End of file UserCT.php */
/* Location: ./application/controllers/UserCT.php */