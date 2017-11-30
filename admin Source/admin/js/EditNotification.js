/**
 * search function to search title game by title
 * @return {[type]} [description]
 */
function search() {
	var search = $('#manager-search').val();
	var elems = document.querySelectorAll("#title");
    var items = document.querySelectorAll("#manager-noti");
    for (i = 0; i < elems.length; i++) {
        items[i].style.display = "block";
    }
    var i = 0;
    for (i = 0; i < elems.length; i++) {
        if (elems[i].textContent.indexOf(search) === -1) {
            items[i].style.display = "none";
        }
    }
}

$(document).ready(function(){
	$('#notifi-list').DataTable();
});