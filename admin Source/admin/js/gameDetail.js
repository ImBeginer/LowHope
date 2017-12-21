function countDown_End_Date(string_end_date) {
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
      
    document.getElementsByClassName("game-close-in")[0].innerHTML = "Còn lại: " + days + "Ngày " + hours + "h " + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(x);
      document.getElementsByClassName("game-close-in")[0].innerHTML = "EXPIRED";
    }         
      
  }, 1000);
}


function checkPermission(email, password, game_id, game_type) {
  $.ajax({
    url: base_url + 'GameDetail/checkPermission',
    type: 'POST',
    dataType: 'text',
    data: {
      email : email,
      password : password,
      game_id : game_id,
      game_type : game_type
    },
  })
  .done(function(response) {
    console.log(response);
    if (response == 1) {
      toatMessage('Success', '<b>Cập nhật thành công!</b>', 'success');
    } else if (response == 2){
      toatMessage('Error', '<b>Email hoặc mật khẩu không đủ quyền hạn! Vui lòng thử lại sau!</b>', 'error');
    } else {
      toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
    }
  })
  .fail(function(response) {
    console.log("error");
  });
}


/**
 * [toatMessage description]
 * @param  {[type]} heading [description]
 * @param  {[type]} text    [description]
 * @param  {[type]} icon    [description]
 * @return {[type]}         [description]
 */
function toatMessage(heading,text,icon) {
  $.toast({
    heading: heading,
    text: text,
    showHideTransition: 'slide',
    icon: icon,
    position: 'bottom-right',
    hideAfter: 5000
  });
}