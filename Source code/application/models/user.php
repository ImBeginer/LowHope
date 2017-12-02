<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('game');		
	}
	
	/**
	 * [checkUserExist description] Kiểm tra tài khoản đăng nhập thường, xem có trùng với tài khoản google với
	 * facebook hay không?
	 * @param  [type] $EMAIL [description]
	 * @return [type]        [description]
	 */
	public function checkUserExist($EMAIL)
	{
		$this->db->select('*');
		$this->db->where('EMAIL', $EMAIL);
		
		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;		
		}else{
			throw new Exception('Error from checkUserExist()');
		}
	}

	/**
	 * [check_Mail_FB_GG description]
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	function check_Mail_FB_GG($EMAIL)
	{
		$this->db->select('*');
		$this->db->where('EMAIL', $EMAIL);
		
		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			if($rows > 0){
				$result = $result->row();
				return $result->USER_CIF?true:false;
			}		
		}else{
			throw new Exception('Error from checkUserExist()');
		}
	}

	/**
	 * [checkUserExistPlus description]
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function checkUserExistPlus($USER_CIF,$USER_EMAIL)
	{
		$condi = array('USER_CIF'=>$USER_CIF, 'EMAIL'=>$USER_EMAIL);
		$this->db->where($condi);
		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from checkUserExistPlus()');
		}
	}

	/**
	 * [get_all_noti_user description]
	 * @param  [type] $userID [description]
	 * @return [type]         [description]
	 */
	function get_all_noti_user($userID)
	{
		$result = $this->db->select('NOTIFICATION_DETAILS.NOTICE_ID, NOTIFICATION.TITLE, NOTIFICATION.CONTENT, NOTIFICATION_DETAILS.GAME_ID, NOTIFICATION_DETAILS.TYPE_ID, NOTIFICATION_DETAILS.SEND_DATE, NOTIFICATION_DETAILS.SEEN')->from('NOTIFICATION_DETAILS')->join('NOTIFICATION', 'NOTIFICATION_DETAILS.NOTICE_ID = NOTIFICATION.NOTICE_ID')->where('NOTIFICATION_DETAILS.USER_ID', $userID)->order_by('NOTIFICATION_DETAILS.SEND_DATE', 'DESC');
		$result = $this->db->get();
		if($result !== FALSE && $result->num_rows()>0){

			$all_noti = $result->result_array();
			$noti_not_seen = 0;

			foreach ($all_noti as $value) {
				if ($value['SEEN'] == 0) {
					$noti_not_seen++;
				}
			}
			$result->all_noti = $all_noti;
			$result->noti_not_seen = $noti_not_seen;
			
			return $result;
		}else{ 
			$result->all_noti = array();
			$result->noti_not_seen = 0;
			return $result;
		}
	}

	/**
	 * Danh sách 3 người chơi đạt giải của game truyền thống trước đó
	 * @param  [type] $gameID [description]
	 * @return [type]         [description]
	 */
	function get_user_achievement_before()
	{
		$gameID = $this->db->select('GAME_ID')->where('ACTIVE', 0)->order_by('GAME_ID', 'DESC');
		$gameID = $this->db->get('SYSTEM_GAMES', 1);
		if($gameID !== false && $gameID->num_rows()>0){
			$gameID = $gameID->row();
			$gameID = $gameID->GAME_ID;
		}else{
			$gameID = null;
		}

		if($gameID){
			$top_users = $this->db->select('AWARD.PRIZE, USERS.USER_NAME')->from('ACHIEVEMENT')->join('AWARD', 'ACHIEVEMENT.AWARD_ID = AWARD.AWARD_ID')->join('USERS', 'ACHIEVEMENT.USER_ID = USERS.USER_ID')->where('AWARD.ACTIVE', 1)->where('ACHIEVEMENT.GAME_ID', $gameID);
			$top_users = $this->db->get();
			if($top_users !== false && $top_users->num_rows()>0){
				return $top_users->result_array();
			}else{
				return array();
			}
		}
	}

	/**
	 * Số lượng thông báo chưa đọc của mỗi người chơi
	 * @param  [type] $userID [description]
	 * @return [type]         [description]
	 */
	public function get_all_noti_not_seen($userID)
	{
		$result = $this->db->select('*')->from('NOTIFICATION_DETAILS')->where('NOTIFICATION_DETAILS.USER_ID', $userID)->where('NOTIFICATION_DETAILS.SEEN', 0);
		$result = $this->db->get();
		if($result !== FALSE && $result->num_rows()>0){
			return $result->num_rows();
		}else{
			return 0;
		}
	}

	/**
	 * [set_seen_noti description]
	 * @param [type] $noti_id   [description]
	 * @param [type] $userID    [description]
	 * @param [type] $send_date [description]
	 */
	public function update_seen_notifi($noti_id, $userID, $game_id, $type_id, $send_date)
	{
		$condi = array('NOTICE_ID'=> $noti_id, 'USER_ID'=> $userID, 'GAME_ID'=>$game_id, 'TYPE_ID'=>$type_id, 'SEND_DATE'=> $send_date);
		$field =  array('SEEN'=> 1);
		$this->db->where($condi);
		$this->db->update('NOTIFICATION_DETAILS', $field);
		return $this->db->affected_rows();
	}

	/**
	 * [get_noti_content description]
	 * @param  [type] $noti_id   [description]
	 * @param  [type] $userID    [description]
	 * @param  [type] $send_date [description]
	 * @return [type]            [description]
	 */
	public function get_noti_content($noti_id, $userID, $game_id, $type_id, $send_date)
	{
		$result = $this->db->select('NOTIFICATION_DETAILS.NOTICE_ID, NOTIFICATION.TITLE, NOTIFICATION.CONTENT, NOTIFICATION_DETAILS.SEND_DATE, NOTIFICATION_DETAILS.SEEN')->from('NOTIFICATION_DETAILS')->join('NOTIFICATION', 'NOTIFICATION_DETAILS.NOTICE_ID = NOTIFICATION.NOTICE_ID')->where('NOTIFICATION_DETAILS.NOTICE_ID', $noti_id)->where('NOTIFICATION_DETAILS.USER_ID', $userID)->where('NOTIFICATION_DETAILS.GAME_ID', $game_id)->where('NOTIFICATION_DETAILS.TYPE_ID', $type_id)->where('NOTIFICATION_DETAILS.SEND_DATE', $send_date);
		$result = $this->db->get();
		if($result !== FALSE && $result->num_rows()>0){
			$result = $result->row();
			return $result;
		}else{ return null;}
	}

	/**
	 * [addUser description]
	 * @param [string] $USER_CIF     [mã số google or facebook của user]
	 * @param [string] $USER_NAME    [description]
	 * @param [string] $USER_EMAIL   [description]
	 * @param [string] $USER_PHONE   [description]
	 * @param [string] $USER_ADDRESS [description]
	 */
	public function addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS,$CREATED_DATE)
	{
		$user = array(
			'ROLE_ID'		=> ROLE_USER,
			'USER_CIF' 		=> $USER_CIF,
			'USER_NAME' 	=> $USER_NAME,
			'USER_POINT' 	=> 500,
			'EMAIL'			=> $USER_EMAIL,
			'PHONE_NUMBER'	=> $USER_PHONE,
			'ADDRESS' 		=> $USER_ADDRESS,
			'ATTENDANCE'	=> 0,
			'ACTIVE'		=> 1,
			'CREATE_DATE'  => $CREATED_DATE
		);

		if($this->db->insert('USERS', $user)){
			return $this->db->insert_id();			
		}else{
			throw new Exception('Error from addUser()');
		}
	}

	/**
	 * [add_other_user description]
	 * @param [type] $email        [description]
	 * @param [type] $pass         [description]
	 * @param [type] $CREATED_DATE [description]
	 */
	public function add_other_user($email, $pass, $CREATED_DATE)
	{
		$user = array(
					'ROLE_ID' 		=> ROLE_USER,
					'USER_NAME' 	=> 'Unknow',
					'USER_POINT' 	=> 500,
					'EMAIL'			=> $email,
					'ATTENDANCE'	=> 0,
					'ACTIVE'		=> 1,
					'PASSWORD'		=> $pass,
					'CREATE_DATE'  => $CREATED_DATE
				);
		if($this->db->insert('USERS', $user)){
			return $this->db->insert_id();			
		}else{
			return null;
		}
	}

	/**
	 * [getUserByMail description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function getUserByMail($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('EMAIL', $USER_EMAIL);
		$user = $this->db->get('USERS');
		if($user){
			$user = $user->row();			
			return $user;
		}else{
			throw new Exception('Error from getUserByMail()');
		}
	}

	/**
	 * [getUserById description]
	 * @param  [type] $USER_ID [description]
	 * @return [type]          [description]
	 */
	public function getUserById($USER_ID)
	{
		$this->db->select('*');
		$this->db->where('USER_ID', $USER_ID);
		$user = $this->db->get('USERS');
		if($user){
			$user = $user->row();			
			return $user;
		}else{
			throw new Exception('Error from getUserByMail()');
		}
	}

	/**
	 * [update_password description]
	 * @param  [type] $email [description]
	 * @param  [type] $pass  [description]
	 * @return [type]        [description]
	 */
	public function update_password($email, $pass)
	{
		$user = array('EMAIL' => $email, 'PASSWORD' => $pass);
		$this->db->where('EMAIL', $email);
		$this->db->update('USERS', $user);
		return $this->db->affected_rows();
	}

	/**
	 * [updateUser description]     google + facebook
	 * @param  [type] $USER_ID      [description]
	 * @param  [type] $USER_NAME    [description]
	 * @param  [type] $USER_PHONE   [description]
	 * @param  [type] $USER_ADDRESS [description]
	 * @return [type]               [description]
	 */
	public function updateUser($USER_ID,$USER_NAME,$USER_PHONE,$USER_ADDRESS)
	{
		$user = array(
			'USER_NAME' => $USER_NAME,
			'PHONE_NUMBER' => $USER_PHONE,
			'ADDRESS' => $USER_ADDRESS
		);

		$this->db->where('USER_ID', $USER_ID);
		$this->db->update('USERS', $user);
	}

	/**
	 * [checkFBUserChanged description]
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function checkFBUserChanged($USER_CIF)
	{
		$condi = array('USER_CIF' => $USER_CIF);
		$this->db->select('*');
		$this->db->where($condi);

		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from checkFBUserChanged()');
		}

	}

	/**
	 * [updateFBUser description] when informations of user was changed
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_NAME  [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function updateFBUser($USER_CIF,$USER_NAME,$USER_EMAIL)
	{
		$user = array(
			'USER_NAME' => $USER_NAME,
			'EMAIL' => $USER_EMAIL
		);

		$this->db->where('USER_CIF', $USER_CIF);
		if(!$this->db->update('USERS', $user)){
			throw new Exception('Error from updateFBUser()');
		}
	}

	/**
	 * [isPlayGame_TT_Active description]
	 * @param  [type]  $userID     [description]
	 * @param  [type]  $game_tt_id [description]
	 * @return boolean             [description]
	 */
	public function isPlayGame_TT_Active($userID, $game_tt_id)
	{
		$condi = array('GAME_ID'=> $game_tt_id, 'USER_ID'=> $userID);

		$this->db->select('*');
		$this->db->where($condi);
		$result = $this->db->get('SYSTEM_GAME_LOGS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}
	}

	/**
	 * [canCreateGame description]
	 * @param  [type] $userID [description]
	 * @return [type]         [description]
	 */
	public function canCreateGame($userID)
	{
		$user = $this->db->select('*')->where('USER_ID', $userID)->get('USERS');
		$user = $user->row();
		$user_point = $user->USER_POINT;

		$condi = array('OWNER_ID'=>$userID, 'ACTIVE'=>1);

		$result_YN = $this->db->select('*')->where($condi)->get('YN_GAMES');
		$rows_YN = $result_YN->num_rows();

		$result_MUL = $this->db->select('*')->where($condi)->get('MULTI_CHOICE_GAMES');
		$rows_MUL = $result_MUL->num_rows();

		$rows = $rows_YN + $rows_MUL;
		return $user_point>=(MAX_PLAYER*FEE_BET_MINI + FEE_CREATE + $rows*MAX_PLAYER*FEE_BET_MINI);
	}

	/**
	 * [canPlayGame description]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function canPlayGame($userID)
	{
		$user = $this->db->select('*')->where('USER_ID', $userID)->get('USERS');
		$user = $user->row();
		$user_point = $user->USER_POINT;

		$condi = array('OWNER_ID'=>$userID, 'ACTIVE'=>1);

		$result_YN = $this->db->select('*')->where($condi)->get('YN_GAMES');
		$rows_YN = $result_YN->num_rows();

		$result_MUL = $this->db->select('*')->where($condi)->get('MULTI_CHOICE_GAMES');
		$rows_MUL = $result_MUL->num_rows();

		$rows = $rows_YN + $rows_MUL;
		
		return $user_point>=(FEE_BET_MINI + $rows*FEE_BET_MINI*MAX_PLAYER);
	}

	/**
	 * [canBetGameTT description]
	 * @param  [type] $userID [description]
	 * @return [type]         [description]
	 */
	public function canBetGameTT($userID)
	{
		$user = $this->db->select('*')->where('USER_ID', $userID)->get('USERS');
		$user = $user->row();
		$user_point = $user->USER_POINT;

		$condi = array('OWNER_ID'=>$userID, 'ACTIVE'=>1);

		$result_YN = $this->db->select('*')->where($condi)->get('YN_GAMES');
		$rows_YN = $result_YN->num_rows();

		$result_MUL = $this->db->select('*')->where($condi)->get('MULTI_CHOICE_GAMES');
		$rows_MUL = $result_MUL->num_rows();

		$rows = $rows_YN + $rows_MUL;
		
		return $user_point>=(FEE_BET_TT + $rows*FEE_BET_MINI*MAX_PLAYER);
	}

	/**
	 * [isOwnerGame description]
	 * @param  [type]  $userID [description]
	 * @param  [type]  $gameID [description]
	 * @return boolean         [description]
	 */
	public function isOwnerGame($userID,$gameID,$type)
	{
		$condi = array('GAME_ID'=>$gameID, 'OWNER_ID'=>$userID);
		if($type == GAME_YN){
			$result = $this->db->select('*')->where($condi)->get('YN_GAMES');
			$result = $result->num_rows();
			return $result>0;			
		}else if($type == GAME_MUL){
			$result = $this->db->select('*')->where($condi)->get('MULTI_CHOICE_GAMES');
			$result = $result->num_rows();
			return $result>0;
		}
	}
	
	/**
	 * Update lại point của người chơi
	 * @param  [type] $userID     [description]
	 * @param  [type] $user_point [description]
	 * @return [type]             [description]
	 */
	public function updatePoint($userID,$user_point)
	{
		$point = array('USER_POINT'=>$user_point);
		$this->db->where('USER_ID', $userID);
		$this->db->update('USERS', $point);
	}

	/**
	 * [update_attendance description]
	 * @param  [type] $userID [description]
	 * @return [type]         [description]
	 */
	public function update_attendance($userID)
	{
		$obj = array('ATTENDANCE' => 1);
		$this->db->where('USER_ID', $userID);
		$this->db->update('USERS', $obj);
		return $this->db->affected_rows();
	}

	/**
	 * Top 3 người chơi có nhiều point nhất
	 * @return [type] [description]
	 */
	public function get_top_point()
	{
		$this->db->select('USER_ID, USER_NAME, USER_POINT');
		$this->db->order_by('USER_POINT', 'desc');
		$top_point = $this->db->get('USERS', 3);
		if($top_point){
			$top_point = $top_point->result_array();
			return $top_point;
		}
	}	

	/**
	 * Kiểm tra xem người dùng có liên quan tới game yes/no không?
	 * @param  [type]  $userID [description]
	 * @return boolean         [description]
	 */
	public function is_related_YN($userID)
	{
		$is_owner = false;
		$is_play = false;

		$this->db->where('OWNER_ID', $userID);
		$owner_YN = $this->db->get('YN_GAMES');

		if($owner_YN->num_rows()>0){
			$is_owner = true;
		}

		$this->db->where('USER_ID', $userID);
		$play_YN = $this->db->get('YN_GAME_LOGS');

		if($play_YN->num_rows()>0){
			$is_play = true;
		}

		if($is_owner || $is_play)return true;
		else return false;
	}

	/**
	 * Kiểm tra xem người dùng có liên quan tới game multi-choice không?
	 * @param  [type]  $userID [description]
	 * @return boolean         [description]
	 */
	public function is_related_MUL($userID)
	{
		$is_owner = false;
		$is_play = false;

		$this->db->where('OWNER_ID', $userID);
		$owner_MUL = $this->db->get('MULTI_CHOICE_GAMES');

		if($owner_MUL->num_rows()>0){
			$is_owner = true;
		}

		$this->db->where('USER_ID', $userID);
		$play_MUL = $this->db->get('MULTI_CHOICE_GAME_LOGS');

		if($play_MUL->num_rows()>0){
			$is_play = true;
		}

		if($is_owner || $is_play)return true;
		else return false;
	}

	/**
	 * [get_profile_user description]
	 * @param  [type] $profile_userID [description]
	 * @return [type]                 [description]
	 */
	public function get_profile_user($id_user_view)
	{
		$user_profile = array();
		//giai he thong
		$achievements_system = $this->db->select('USERS.USER_NAME, ACHIEVEMENT.GAME_ID, SYSTEM_GAMES.START_DATE, SYSTEM_GAMES.END_DATE, AWARD.PRIZE')->from('ACHIEVEMENT')->join('AWARD', 'ACHIEVEMENT.AWARD_ID = AWARD.AWARD_ID')->join('USERS', 'ACHIEVEMENT.USER_ID = USERS.USER_ID')->join('SYSTEM_GAMES', 'ACHIEVEMENT.GAME_ID = SYSTEM_GAMES.GAME_ID')->where('AWARD.ACTIVE', 1)->where('ACHIEVEMENT.USER_ID', $id_user_view)->order_by('SYSTEM_GAMES.START_DATE');

		$achievements_system = $this->db->get();

		if($achievements_system !== false && $achievements_system->num_rows()>0){
			$user_profile['achievements_system'] = $achievements_system->result_array();
		}else{
			$user_profile['achievements_system'] = array();
		}

		//giai thu thach
		//yes/no
		$result_bet_yes_no_game = $this->db->select('YN_GAME_LOGS.USER_ID, YN_GAME_LOGS.GAME_ID, YN_GAMES.TITLE, YN_GAME_LOGS.IS_WINNER')->from('YN_GAME_LOGS')->join('YN_GAMES', 'YN_GAME_LOGS.GAME_ID = YN_GAMES.GAME_ID')->where('YN_GAME_LOGS.USER_ID', $id_user_view);

		$result_bet_yes_no_game = $this->db->get();
		
		if($result_bet_yes_no_game !== false && $result_bet_yes_no_game->num_rows()>0){
			$result_bet_yes_no_game = $result_bet_yes_no_game->result_array();
			foreach ($result_bet_yes_no_game as &$value) {
				$value = (object)$value;
				$value->TYPE = 'YN';
				$value = (array)$value;
			}
		}else{
			$result_bet_yes_no_game = array();
		}

		//giai thu thach
		//multiple choice
		$result_bet_multi_game = $this->db->select('MULTI_CHOICE_GAME_LOGS.USER_ID, MULTI_CHOICE_GAME_LOGS.GAME_ID, MULTI_CHOICE_GAMES.TITLE, MULTI_CHOICE_GAME_LOGS.IS_WINNER')->from('MULTI_CHOICE_GAME_LOGS')->join('MULTI_CHOICE_GAMES', 'MULTI_CHOICE_GAME_LOGS.GAME_ID = MULTI_CHOICE_GAMES.GAME_ID')->where('MULTI_CHOICE_GAME_LOGS.USER_ID', $id_user_view);

		$result_bet_multi_game = $this->db->get();
		
		if($result_bet_multi_game !== false && $result_bet_multi_game->num_rows()>0){
			$result_bet_multi_game = $result_bet_multi_game->result_array();
			foreach ($result_bet_multi_game as &$value) {
				$value = (object)$value;
				$value->TYPE = 'MUL';
				$value = (array)$value;
			}
		}else{
			$result_bet_multi_game = array();
		}

		$user_profile['result_bet_mini_game'] = array_merge($result_bet_yes_no_game, $result_bet_multi_game);

		return $user_profile;
		
	}
}

/* End of file User.php */
/* Location: ./application/models/User.php */