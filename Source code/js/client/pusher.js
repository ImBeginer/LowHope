/*********************************************** PUSHER **********************************************************/
// Pusher.logToConsole = true;
var pusher = new Pusher('711b956416d9d15de4b8', {
  cluster: 'ap1',
  encrypted: true,
  disableStats:true
});

//key moi: efd4e401d751e081f0f0
//Pusher Quan
var pusher_admin = new Pusher('35555731a8560ac49e3b', {
  cluster: 'ap1',
  encrypted: true,
  disableStats:true
});

//Pusher Huy
var pusher_3 = new Pusher('df4ed713f2f76fde17d4', {
  cluster: 'ap1',
  encrypted: true,
  disableStats:true
});

/*********************************************** ADMIN **********************************************/

var listen_admin = pusher_admin.subscribe('create_noti_channel');
listen_admin.bind('create_noti_event', function(data) {
  console.log('listen_admin: ' + data);
});

/**************************************** NOTIFICATION **********************************************/
$(document).on('click', '.noti-items', function(event) {
  event.preventDefault();

  $('#notifi-popup-title').remove();
  $('#nd-noti').remove();

  $('#notifi-title').prepend('<i class="fa fa-spinner fa-pulse fa-fw waiting" style="color:black"></i>');
  $('#notifi-content').append('<i class="fa fa-spinner fa-pulse fa-fw waiting" style="color:black"></i>');

  var current = $(this);
  //1.Add class
  current[0].firstElementChild.firstElementChild.children[1].className += " already-read";
  //2.Load conten noti
  //3.Gui thong bao da xem cho server check 
  var noti_id = current.attr("data-noID");
  var game_id = current.attr("data-gameID");
  var type_id = current.attr("data-gameType");
  var send_date = current[0].firstElementChild.firstElementChild.children[2].children[1].innerText;
  if(current.attr("data-seen") == 0){
    current.attr('data-seen', 1);
    set_and_get_noti(noti_id, game_id, type_id, send_date, 'update_seen_noti');
  }else if(current.attr("data-seen") == 1){
    set_and_get_noti(noti_id, game_id, type_id, send_date, 'get_noti_content');
  }
});

/**
 * [set_and_get_noti description] lấy thông báo hoặc update thông báo chưa xem-> đã xem
 * @param {[type]} noti_id       [description]
 * @param {[type]} send_date     [description]
 * @param {[type]} function_name [description]
 */
function set_and_get_noti(noti_id, game_id, type_id, send_date, function_name) {
  $.ajax({
      url: base_url + 'userct/' + function_name,
      type: 'POST',
      dataType: 'JSON',
      data: {noti_id: noti_id, game_id: game_id, type_id:type_id, send_date: send_date},
    }).done(function(response) {
      if(response){
        $('.waiting').remove();

        if(response.noti_content.CONTENT.indexOf('REPLACE') >=0 ){
          response.noti_content.CONTENT = response.noti_content.CONTENT.replace('REPLACE', 'game-id: ' + game_id + '. Xem chi tiết tại <a href="'+ base_url +'userct/history">đây</a>');
        }else if(response.noti_content.CONTENT.indexOf('ENDGAME') >= 0){
          response.noti_content.CONTENT = response.noti_content.CONTENT.replace('ENDGAME', 'Game-id: ' + game_id);
          response.noti_content.CONTENT += ' Xem chi tiết tại <a href="'+ base_url +'userct/history">đây</a>';
        }

        $('#notifi-title').prepend('<h5 class="modal-title" id="notifi-popup-title"><i class="fa fa-info-circle" style="color:black" aria-hidden="true"></i> '+response.noti_content.TITLE+'</h5>');
        $('#notifi-content').append('<p class="notifi-message" id="nd-noti">'+response.noti_content.CONTENT+'</p>');

        if(response.noti_not_seen != null){
          $('.notifi-num p')[0].innerText = response.noti_not_seen;
        }
      }
    }).fail(function(response) {
      console.log("set_and_get_noti: error");
    });
}

//add thông báo vào danh sách thông báo
function add_noti(noti_id, noti_seen, game_type, game_id, noti_title, send_date, user_point) {
  send_date = moment(send_date).format('H:mm:ss DD-MM-YYYY');
  //Xóa không có thông báo
  if($('ul#user-notifi li.noti-nothing')[0]){
    $('ul#user-notifi li.noti-nothing')[0].remove();
  }

  var html = '';
  html += '<li class="noti-items" data-noID="'+ noti_id +'" data-seen="'+ noti_seen +'" data-gameType="'+ game_type +'" data-gameID="'+ game_id +'" class="btn btn-primary" data-toggle="modal" data-target="#notifi-popup">';
  html += '<div class="noti-content ellipsis">';
  html += '<a href="#!">';
  html += '<p class="notifi-title" class="ellipsis">';
  html += '<div id="circle-read-1" class="green-circle d-inline-block" data-is-read="false"></div> ';
  html +=  noti_title;
  html += '<div class="time-area">';
  html += '<span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>';
  html += '<span class="send-date"> ' + send_date + '</span>';
  html += '</div>';
  html += '</p>';
  html += '</a>';
  html += '</div>';
  html += '</li>';

  var num_noti = parseInt($('.notifi-num p')[0].textContent);
  num_noti++;  
  $('.notifi-num p')[0].innerText = num_noti;
  $('#user-notifi').prepend(html);
  $('#user-point').text(user_point);
}

//Kênh lắng nghe về game yes no
function listen_yes_no_game() {
  var channel_yn_game = pusher_3.subscribe('yn-game');
  channel_yn_game.bind('pop-players', function(data) {
    console.log('from yes no game: '+ data);
    $.each(data, function(key, value) {
      if(user_id == value.USER_ID){
        add_noti(value.NOTICE_ID, value.SEEN, value.TYPE_ID, value.GAME_ID, value.NOTICE_TITLE, value.SEND_DATE, value.USER_POINT);
      }
    });
    //Xóa item trên slide
    $('.hot-item[data-gameid='+ data[0].GAME_ID +'][data-gametype='+ data[0].TYPE_ID +']').remove();
    //Kiểm tra slide còn item nào không thì chạy chữ
    if($('.hot-item').length == 0){
      $('#hot-mini-game-area').prepend('<marquee behavior="scroll" direction="left">Các thử thách đang được hệ thống cập nhật. Hãy tạo nhiều thử thách cho người khác để kiếm nhiều point nào <span><i class="fa fa-smile-o" aria-hidden="true" style="color:pink"></i></span></marquee>');
    }
  });
}

//Kênh lắng nghe multi game
function listen_multi_game() {
  var channel_multi_game = pusher_3.subscribe('multi-game');
  channel_multi_game.bind('pop-players', function(data) {
    console.log('from multi game: '+ data);
    $.each(data, function(key, value) {
      if(user_id == value.USER_ID){
        add_noti(value.NOTICE_ID, value.SEEN, value.TYPE_ID, value.GAME_ID, value.NOTICE_TITLE, value.SEND_DATE, value.USER_POINT);
      }
    });
    //Xóa item trên slide
    $('.hot-item[data-gameid='+ data[0].GAME_ID +'][data-gametype='+ data[0].TYPE_ID +']').remove();
    //Kiểm tra slide còn item nào không thì chạy chữ
    if($('.hot-item').length == 0){
      $('#hot-mini-game-area').prepend('<marquee behavior="scroll" direction="left">Các thử thách đang được hệ thống cập nhật. Hãy tạo nhiều thử thách cho người khác để kiếm nhiều point nào <span><i class="fa fa-smile-o" aria-hidden="true" style="color:pink"></i></span></marquee>');
    }
  });
}

//Các kênh lắng nghe thông báo từ game hệ thống
if(typeof user_id !== 'undefined'){
  //Kênh hệ thống
  var channel_system_game = pusher_3.subscribe('system-game');
  //Tất cả người chơi
  channel_system_game.bind('pop-users', function(data) {
    //console.log('from system game for all: '+ data);
    $.each(data, function(key, value) {
    if(user_id == value.USER_ID){
        add_noti(value.NOTICE_ID, value.SEEN, value.TYPE_ID, value.GAME_ID, value.NOTICE_TITLE, value.SEND_DATE, value.USER_POINT);
      }
    });
    //Update lại giao diện
    $.ajax({
      url: base_url + 'gamect/update_session_game_tt',
      type: 'POST',
      dataType: 'JSON',
      data: {gameID: data[0].GAME_ID},
    })
    .done(function(response) {
      //clear chat
      $('.chat-body.pre-scrollable').empty();

      //Nội dung game truyền thống
      if($('.game_tt_content.text-center')[0]){
        var content = 'Câu hỏi tuần này: ';
        content += response.new_game.CONTENT;
        content += ' là bao nhiêu?';
        $('.game_tt_content.text-center')[0].textContent = content;
      }

      //Đếm ngược thời gian
      if($('#countDown')[0]){
        document.getElementById("countDown").style.color = 'white';
        document.getElementById("countDown").style.fontWeight  = 'normal';
        $("#bet-game_tt").prop('disabled', false);
        countDown_End_Date(response.new_game.END_DATE, 0);
      }

      //Giá dự đoán trước của người chơi
      if($('#price-bet-before')[0]){
        $('#price-bet-before')[0].textContent = '(Bạn chưa tham gia dự đoán)';
      }

      //Update lại giải thưởng chạy
      if($('#top_users_achievement')[0]){
        if($('#top_users_achievement marquee')[0]){
          $('#top_users_achievement marquee span')[0].textContent = response.top_users_achievement[0].USER_NAME;
          $('#top_users_achievement marquee span')[1].textContent = response.top_users_achievement[1].USER_NAME;
          $('#top_users_achievement marquee span')[2].textContent = response.top_users_achievement[2].USER_NAME;
        }else{
          $('#top_users_achievement')[0].firstChild.remove();
          var tag = document.createElement('marquee');
          $('#top_users_achievement')[0].append(tag);
          var html = '';
          html += 'Chúc mừng người chơi: <span style="color: #ffbf01;">';
          html += response.top_users_achievement[0].USER_NAME;
          html += '</span> giành GIẢI NHẤT,';
          html += '<span style="color: #ffbf01;">';
          html += response.top_users_achievement[1].USER_NAME;
          html += '</span> giành GIẢI NHÌ,';
          html += '<span style="color: #ffbf01;">';
          html += response.top_users_achievement[2].USER_NAME;
          html += '</span> giành GIẢI BA trong game hệ thống tuần trước. Game hệ thống mới đã được cập nhật, mọi người nhanh tay đặt cược để nhận những giải thưởng giá trị khác.';
          $('#top_users_achievement')[0].firstElementChild.innerHTML  = html;
        }
      }

    })
    .fail(function(response) {
      console.log("update_session_game_tt: error");
    });
    
  });

  //Kiểm tra người chơi có tham gia game hệ thống không thi cho subscrice kênh này
  channel_system_game.bind('pop-winners', function(data) {
    //console.log('from system game for winners: '+ data);
    $.each(data, function(key, value) {
    if(user_id == value.USER_ID){
        add_noti(value.NOTICE_ID, value.SEEN, value.TYPE_ID, value.GAME_ID, value.NOTICE_TITLE, value.SEND_DATE, value.USER_POINT);
      }
    });
  });

  //Kiểm tra user có là chủ game yes/no nào không, hay chơi game yes/no nào không?
  //Nhận thông báo sau khi kết thúc game YES NO
  if(is_related_YN){
    listen_yes_no_game();
  }

  //Nhận thông báo sau khi kết thúc game multi
  if(is_related_MUL){
    listen_multi_game();
  }

  //add tin nhắn vào bảng chat
  var channel_room_chat = pusher.subscribe('channel_room_chat');
  channel_room_chat.bind('receive_message', function(data){
    if(user_id !== data.userID){
      var send_time = moment(data.send_date).format('H:mm');  
      add_message_to_room(data.avatar, data.userName, send_time, data.message);
    }
  });

}else{
  console.log('Not user');
}

//data
var channel_add_data = pusher_3.subscribe('bitcoin_rate');
channel_add_data.bind('broadcasting', function(data) {
  if(typeof $('#btc_today p')[0] !== 'undefined'){
    $('#btc_today p')[0].innerText = data.price + ' USD';
  }
});

/*************************************** END NOTI *************************************************************/


/*************************************** START ALL ACTIVITIES ************************************************/
/**
 * update lại table lịch sử log game yes no
 * [channel description]
 * @type {[type]}
 */
var channel_log_game_yn = pusher.subscribe('log_game_yes_no_channel');
channel_log_game_yn.bind('log_game_yes_no_event', function(data) {
  updateItemSlide(data.gameID, 1, data.total_amount);
  user_percent_in_de(data.ans_yes, data.ans_no);
  format_data_table(data);
  load_table_log_game(data.list_bet_log);
  // set_style_table_log_game();
});

/**
 * update lại table lịch sử log game mul
 * [channel description]
 * @type {[type]}
 */
var channel_log_game_mul = pusher.subscribe('log_game_mul_channel');
channel_log_game_mul.bind('log_game_mul_event', function(data) {
  updateItemSlide(data.gameID, 2, data.total_amount);
  user_percent_mul(data.PRICE_BELOW, data.PRICE_BETWEEN, data.PRICE_ABOVE);
  format_data_table(data);
  load_table_log_game(data.list_bet_log);
  // set_style_table_log_game();
});

/**
* add item vào giao diện slide khi có game mới được tạo
* update item to slide
* @type {[type]}
*/
var channel_create_game_yn = pusher.subscribe('create_game_yes_no_channel');
channel_create_game_yn.bind('create_game_yes_no_event', function(data) {
  addItemSlide(data.gameID, 1, data.game_title, data.user_create, data.total_amount);
  infinitySlideShow();
});

/**
* [channel_create_game_mul description]
* @type {[type]}
*/
var channel_create_game_mul = pusher.subscribe('create_game_mul_channel');
channel_create_game_mul.bind('create_game_mul_event', function(data) {
  addItemSlide(data.gameID, 2, data.game_title, data.user_create, data.total_amount);
  infinitySlideShow();
});

function add_message_to_room(avatar, userName, send_time, message){
  var html = '';
  html += '<div class="message-box mt-2">';
  html += '<div class="user-info">';
  html += '<img src="';
  html += avatar;
  html += '"></div>';
  html += '<div class="user-message">';
  html += '<div class="user-message-up">';
  html += '<div class="chat-name float-left">';
  html += userName;
  html += '</div>';
  html += '<div class="chat-time float-right">';
  html += send_time;
  html += '</div>';
  html += '</div>';
  html += '<div class="user-message-down">';
  html +=  message;
  html += '</div>';
  html += '</div>';
  html += '</div>';
  var element = $.parseHTML(html);
  $('.chat-body.pre-scrollable')[0].append(element[0]);
}

/****************************************************************************************************************/

/**
 * [loadTable description]
 * @param  {[type]} list_bet_log [description]
 * @return {[type]}              [description]
 */
function load_table_log_game(list_bet_log) {
  var el = $('#list-bet-log');
  if(el.hasClass('table')){
    el.DataTable({
      language: {
        "emptyTable": "Hãy là người đầu tiên cược game này.",
        "zeroRecords": "Rất tiếc, không có dữ liệu phù hợp." ,
        "paginate": {
          "previous": "Trước",
          "next": "Sau"
        }
      },
      autoWidth: true,
      columns: [
        { data: 'ANS_TIME' },
        { data: 'USER_NAME' }     
      ],
      data: list_bet_log,
      bDestroy: true
    });
  };
}

/**
 * [updateItemSlide description]
 * @param  {[type]} game_id      [description]
 * @param  {[type]} game_type    [description]
 * @param  {[type]} total_amount [description]
 * @return {[type]}              [description]
 */
function updateItemSlide(game_id, game_type, total_amount) {
  var elements = $('.hot-item');
  if(elements.length > 0){
    for (var i = 0; i < elements.length; i++) {
      if (elements[i].getAttribute('data-gameid') == game_id && elements[i].getAttribute('data-gametype') == game_type) {
        elements[i].children[0].children[2].children[1].textContent = total_amount;
      }
    }
  }
  $('.mini-game-transaction').text('Point hiện tại: ' + total_amount);
}

/**
 * [addItemSlide description]
 * @param {[type]} gameID       [description]
 * @param {[type]} gameType     [description]
 * @param {[type]} game_title   [description]
 * @param {[type]} user_create  [description]
 * @param {[type]} total_amount [description]
 */
function addItemSlide(gameID, gameType, game_title, user_create, total_amount) {
  if($('#hot-mini-game-area marquee')[0]){
    $('#hot-mini-game-area marquee')[0].remove();
  }

  if($('#hot-mini-game-content')[0]){
    var type = '';
    if(gameType == 1) {type = 'yn'}
    else if(gameType == 2) {type = 'mul'}
    var html = '';
    html += '<div class="hot-item" data-gameID="'+ gameID +'" data-gameType="'+ gameType +'">';
    html += '<a href="'+ base_url + 'gamect/' + type + '/' + gameID +'" title="'+ game_title +'">';
    html += '<div class="title">'+ game_title +'</div>';
    html += '<div class="runner">'+ user_create +'</div>';
    html += '<div class="prob">';
    html += '<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>';
    html += '<span>'+ ' ' + total_amount +'</span>';
    html += '</div></a></div>';
    $('#hot-mini-game-content').append(html);
  }else{
    
    //lan add dau tien
    $('#hot-mini-game-area').append('<div id="hot-mini-game-content" class="hot-minigame slider autoplay"></div>');
    var type = '';
    if(gameType == 1) {type = 'yn'}
    else if(gameType == 2) {type = 'mul'}
    var html = '';
    html += '<div class="hot-item" data-gameID="'+ gameID +'" data-gameType="'+ gameType +'">';
    html += '<a href="'+ base_url + 'gamect/' + type + '/' + gameID +'" title="'+ game_title +'">';
    html += '<div class="title">'+ game_title +'</div>';
    html += '<div class="runner">'+ user_create +'</div>';
    html += '<div class="prob">';
    html += '<span class="icon-arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></span>';
    html += '<span>'+ ' ' + total_amount +'</span>';
    html += '</div></a></div>';
    $('#hot-mini-game-content').append(html);
  }

}

/**
 * [format_data_table description] đưa 
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function format_data_table(data) {
  //format link to view profile user
  for (var i = 0; i < data.list_bet_log.length; i++) {
    data.list_bet_log[i].USER_NAME = '<a href="'+ base_url +'userct/profile/' 
    + data.list_bet_log[i].USER_ID  +'" title="Click để xem hồ sơ">' + data.list_bet_log[i].USER_NAME + '</a>';
  }
}

/**
 * [set_style_table_log_game description] đặt lại style cho bảng danh sách người chơi đã tham gia game mini
 */
function set_style_table_log_game() {
  var giaodich = $('.giaodich');
  giaodich[0].style.fontSize = '30px';
  giaodich[0].style.fontWeight = 'bold';

  var el_show = $('#list-bet-log_length');
  el_show[0].children[0].firstChild.textContent = 'Hiển thị ';
  el_show[0].children[0].firstChild.nextSibling.style.backgroundColor = '#777';
  el_show[0].children[0].firstChild.nextSibling.nextSibling.textContent = ' bản ghi';

  var el_search = $('#list-bet-log_filter');
  el_search[0].firstChild.firstChild.textContent = 'Tìm kiếm: ';
  el_search[0].style.width = '100%';
  el_search[0].firstChild.firstChild.nextSibling.style.width = '50%';
  el_search[0].firstChild.firstChild.nextSibling.style.float = 'right';
}

/**
 * [countDown_End_Date description]
 * @param  {[type]} string_end_date [description]
 * @param  {[type]} type            [description]
 * @return {[type]}                 [description]
 */
function countDown_End_Date(string_end_date,type) {
  var end_date = (new Date(string_end_date)).getTime();
  
  var x = setInterval(function(){
    // Get todays date and time
    var now = new Date().getTime();
      // Find the distance between now an the count down date
      var distance = end_date - now;
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element
      if(type == 0){

        if(days == 0 && hours == 0 && minutes == 0 && seconds == 30){
          document.getElementById("countDown").style.color = 'red';
        }

        if(days == 0 && hours == 0 && minutes == 0 && seconds == 10){
          document.getElementById("bet-game_tt").disabled = 'true';
        }
        document.getElementById("countDown").innerHTML = days + "Day " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        // If the count down is over, write some text 
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("countDown").innerHTML = "ĐÃ ĐÓNG";
          document.getElementById("countDown").style.color  = 'red';
          document.getElementById("countDown").style.fontWeight  = 'bold';
          document.getElementById("bet-game_tt").disabled = 'true';
        }         
      }else if(type == 1){
        if(days == 0 && hours == 0 && minutes == 0 && seconds == 30){
          document.getElementById("game_mini_countdown").style.color = 'red';
        }

        //Khi con 10s thi disable buton dat cuoc
        if(days == 0 && hours == 0 && minutes == 0 && seconds <= 10){
          if($('button#bet-game-yes-no')[0]){
            $('button#bet-game-yes-no')[0].disabled = true;
          }

          if($('button#bet-game-mul')[0]){
            $('button#bet-game-mul')[0].disabled = true;
          }
          
        }

        document.getElementById("game_mini_countdown").innerHTML = days + "Day " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        // If the count down is over, write some text 
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("game_mini_countdown").innerHTML = "ĐÃ ĐÓNG";
          document.getElementById("game_mini_countdown").style.color  = 'red';
          document.getElementById("game_mini_countdown").style.fontWeight  = 'bold';
          $('.mini-game-des')[0].firstElementChild.textContent = 'ĐÃ ĐÓNG';

          if($('button#bet-game-yes-no')[0]){
            $('button#bet-game-yes-no')[0].disabled = true;
          }

          if($('button#bet-game-mul')[0]){
            $('button#bet-game-mul')[0].disabled = true;
          }

        }
      }
  }, 1000);
}

/**
 * [user_percent_in_de description] tỉ lệ người chơi đã cược game yes no
 * @param  {Number} $in_num [description]
 * @param  {Number} $de_num [description]
 * @return {[type]}         [description]
 */
function user_percent_in_de ($in_num = 0, $de_num = 0) {
    $percent_width = parseInt($('.percent-panel').css('width'), 10);

    $in_div = $('#increase');
    $de_div = $('#decrease');
    $in_user = $in_num;
    $de_user = $de_num;
    $total_user = parseInt($in_user) + parseInt($de_user);

    if ($total_user !== 0 && $total_user > 0) {
        $in_div_width = Math.round(($percent_width * $in_user) / $total_user);
        $de_div_width = $percent_width - $in_div_width;
    } else {
        $de_div_width = $in_div_width = Math.round($percent_width / 2);
    }

    $in_per_string = Math.round(($in_div_width / $percent_width) * 100);
    $de_per_string = 100 - $in_per_string;

    $in_div.css({'width': $in_div_width + 'px'});
    $de_div.css({'width': $de_div_width + 'px'});

    $('span.in-num-percent').text($in_per_string + '%');
    $('span.de-num-percent').text($de_per_string + '%');
}

/**
 * [user_percent_mul description] tỉ lệ người chơi đã cược game multi
 * @param  {Number} $lower   [description]
 * @param  {Number} $between [description]
 * @param  {Number} $upper   [description]
 * @return {[type]}          [description]
 */
function user_percent_mul ($lower = 0, $between = 0, $upper = 0) {
    $percent_width = parseInt($('.game-mul.percent-panel').css('width'), 10) - 2;
    $total = parseInt($lower) + parseInt($between) + parseInt($upper);
    $lo_div = $('#increase');
    $be_div = $('#between');
    $up_div = $('#decrease');
    $lo_div_width = $be_div_width = $up_div_width = 0;

    if ($total !== 0 && $total > 0) {
      $lo_div_width = Math.round(($percent_width * $lower) / $total);
      $be_div_width = Math.round(($percent_width * $between) / $total);
      $up_div_width = $percent_width - $lo_div_width - $be_div_width;      
    } else {
      $lo_div_width = $be_div_width = $lo_div_width = Math.round($percent_width / 3) - 1;
    }

    $lo_per_string = Math.round(($lo_div_width / $percent_width) * 100);
    $be_per_string = Math.round(($be_div_width / $percent_width) * 100);
    $up_per_string = 100 - $lo_per_string - $be_per_string;

    $lo_div.css({'width': $lo_div_width + 'px'});
    $be_div.css({'width': $be_div_width + 'px'});
    $up_div.css({'width': $up_div_width + 'px'});

    $('.game-mul span.in-num-percent').text($lo_per_string + '%');
    $('.game-mul span.be-num-percent').text($be_per_string + '%');
    $('.game-mul span.de-num-percent').text($up_per_string + '%');
}

function infinitySlideShow () {
  // tìm stylesheet có chứa rules
  $styleSheet = document.styleSheets[0];
  console.log(document.styleSheets);
  // chọn rules đầu tiên trong file stylesheet 
  $infinitySlide = $styleSheet.cssRules[0];
  // get from (0%) của rules
  $infinitySlide_From = $infinitySlide.cssRules[0];
  // get to (100%) của rules 
  $infinitySlide_To = $infinitySlide.cssRules[1];

  // get đối tượng parentHotItem
  $parentHotItem = $('#hot-mini-game-content');
  // get chiều rộng màn hình browser
  $bodyWidth = parseInt ($('body').css('width'), 10);
  // get số lượng hotItems
  $hotItems = $parentHotItem.children().length;
  // tính toán thời điểm kết thúc slideshow
  if ($hotItems > 9) {
    // get chiều rộng của 1 phần tử hotItems
    $widthOfHotItem = 150;
    // tính toán số phần tử hotItems tối đa có thể hiển thị trên màn hình
    $itemPerScreen = Math.floor ($bodyWidth / $widthOfHotItem);
    // chiều rộng của tất cả phần tử hotItems
    $widthOfAllItem = $hotItems * $widthOfHotItem;
    // thời điểm kết thúc slideshow
    $endSlideShow = $widthOfAllItem - ($itemPerScreen * $widthOfHotItem);
    // tỷ lệ thời gian kết thúc slideshow
    $endTime = Math.ceil($endSlideShow / 20);
    // đặt lại chiều rộng và thời gian cho đối tượng parentHotItem
    $parentHotItem.css('width', $widthOfAllItem);
    $parentHotItem.css('animation-duration', $endTime + 's');
    // get đối tượng style của rules (100%)
    $infinitySlide_To_Style = $infinitySlide_To.style;
    // add lại thuộc tính transform của rules (100%)
    $infinitySlide_To_Style.setProperty('transform', 'translate(' + (-1 * ($endSlideShow + 50)) + 'px)');
  }

};