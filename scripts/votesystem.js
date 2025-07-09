function upvote(id) {
        $.ajax({
        url:"php/upvote.php", //the page containing php script
	data: { sigid: id }, //passes ID of the database entry corresponding to the button line into the PHP script as sigid
        type: "POST", //request type
        success:function(result){
         alert(result); //change 'Upvoted' to "result" (with no quotes) to echo back output from called php script
       }
     });
}

function downvote(id) {
        $.ajax({
        url:"php/downvote.php", //the page containing php script
	data: { sigid: id }, //passes ID of the database entry corresponding to the button line into the PHP script as sigid
        type: "POST", //request type
        success:function(result){
         alert(result); //change 'Downvoted' to "result" (with no quotes) to echo back output from called php script
       }
     });
}
