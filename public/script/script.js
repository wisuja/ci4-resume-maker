let canChat = true;

// create chat dari user
function createChat(messages) {
  // create element
  let row = document.createElement("div");
  let col = document.createElement("div");

  // add class
  row.classList.add("row");
  row.classList.add("mb-3");
  row.classList.add("justify-content-end");
  col.classList.add("col");
  col.classList.add("message");
  col.append(messages);
  row.append(col);
  return row;
}

// Listen for enter key on chatbox
$("#chatbox").keypress(function (e) {
  if (e.which == 13) {
    $("#sendButton").click();
    return false;
  }
});

// Kalau Send Button ditekan untuk kondisi
$("#sendButton").on("click", function () {
  if (canChat == false) {
    alert("Please wait!");
    return;
  }

  if ($("#chatbox").val().trim() !== "") {
    canChat = false;
    $("#spinner").show();

    if ($("#chatbox").val().trim() == "/logout") {
      window.location.href = "/logout";
      return;
    }

    $.ajax({
      url: "/chats",
      data: {
        username: $("#sendButton").data("username"),
        message: $("#chatbox").val().trim(),
      },
      method: "POST",
      success: function (result) {
        console.log(result);
        $("#chat-body-container").append(
          createChat($("#chatbox").val().trim())
        );
        $("#chat-body-container").append(result);
        $("#chatbox").val("");

        $(".col").last()[0].scrollIntoView();

        canChat = true;
        $("#spinner").hide();
      },
    });
  } else {
    return alert("You are trying to chat nothing");
  }
});
