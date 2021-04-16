let canChat = true;

// create chat dari user
function createChat(messages) {
  // create element
  let div1 = document.createElement('div');
  let div2 = document.createElement('div');

  // add class
  div1.classList.add('row');
  div1.classList.add('mb-3');
  div1.classList.add('justify-content-end');
  div2.classList.add('col');
  div2.classList.add('message');
  div2.append(messages);
  div1.append(div2);
  return div1;
}

// Listen for enter key on chatbox
$('#chatbox').keypress(function (e) {
  if (e.which == 13) {
    $('#sendButton').click();
    return false;
  }
});

// Kalau Send Button ditekan untuk kondisi
$('#sendButton').on('click', function () {
  if (canChat == false) {
    alert('Please wait!');
    return;
  }

  if ($('#chatbox').val().trim() !== '') {
    canChat = false;
    $('#spinner').show();

    $.ajax({
      url: '/chats',
      data: {
        username: $('#sendButton').data('username'),
        message: $('#chatbox').val().trim(),
      },
      method: 'POST',
      success: function (result) {
        $('#chat-body-container').append(
          createChat($('#chatbox').val().trim())
        );
        $('#chat-body-container').append(result);
        $('#chatbox').val('');

        $('.col').last()[0].scrollIntoView();

        canChat = true;
        $('#spinner').hide();
      },
    });
  } else {
  }
});
