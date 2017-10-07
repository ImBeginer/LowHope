$(document).ready(function() {      
  $('.danhmuc a#tatca').addClass('hienlen');

  setTimeout(function(){ $('.danhmuc a#tatca').click()}, 100);

  var $grid =  $('.list-minigame').isotope({
    // options
    itemSelector: '.minigame',
    layoutMode: 'masonry',
  });

  $('.danhmuc a').click(function(){
    $('.danhmuc a').removeClass('hienlen');

    $(this).addClass('hienlen');

    danhmuc = $(this).attr('href');

    $grid.isotope({ filter: danhmuc });

    return false;
  }); 
});