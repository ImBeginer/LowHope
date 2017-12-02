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

// $('.game-func p.tag.active-func a.deactive-game').on ('click', function (event) {
//     $gameId = $(this).attr('id');
//     $("#dialog-confirm").html('<div class="change-gift-pass-panel"><span class="black admin-confirm"><i class="fa fa-exclamation" aria-hidden="true"></i>Xác nhận danh tính</span><input type="text" name="admin-email" placeholder="Tài khoản email" id="admin-email" class="form-control black"><input type="password" name="admin-pass" placeholder="Mật khẩu" id="admin-pass" class="form-control black"></div>');
//     $("#dialog-confirm").dialog({
//       resizable: false,
//       height: "auto",
//       width: 400,
//       modal: true,
//       draggable: false,
//       buttons: [
//         {
//           text: "Chắc chắn",
//           "class": 'confirm-yes-btn btn medium-font-size',
//           click: function() {
//             $( this ).dialog( "close" );
//             console.log ('ADMIN EMAIL TRADI: ' + $('input#admin-email').val());
//             console.log ('ADMIN PASS TRADI: ' +  $('input#admin-pass').val());
//           }
//         },
//         {
//           text: "Hủy bỏ",
//           "class": 'confirm-cancel-btn btn medium-font-size',
//           click: function() {
//             $( this ).dialog( "close" );
//           }
//         }
//       ],
//     }); 
//   });