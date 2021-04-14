// Kalau Send Button ditekan
$("#sendButton").on("click", function () {
  $.ajax({
    url: "/chats",
    data: {
      username: $("#sendButton").data("username"),
      message: $("#chatbox").val(),
    },
    method: "POST",
    success: function (result) {
      console.log(result);
    },
  });
});
