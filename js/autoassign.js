function timedCount() {
  $.ajax({
    type: "GET",
    url: 'http://test.yellox.ph/autoassign.php',
    success: function(data){
      setTimeout("timedCount()",1000);
    },
    error: function(err){
      setTimeout("timedCount()",1000);
    }
  });
}
timedCount();

function activate_request() {
    $.ajax({
      type: "GET",
      url: 'http://test.yellox.ph/activate_request.php',
      success: function(data){
        setTimeout("activate_request()",1000);
      },
      error: function(err){
        setTimeout("activate_request()",1000);
      }
    });
}
activate_request();