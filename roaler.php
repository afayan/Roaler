<?php
include_once "database.php";




?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roaler</title>
    <link rel="stylesheet" href="roaler.css">
</head>
<body>
    <header>
        Roaler

        <?php
        

echo "hey";

        ?>
      </header>

      <div class="centre">
        <div class="Roll" id="Roll">

        <?php



    renderMessages($conn);


      function renderMessages($conn){
        $getMessages = "select * from messages;";

        $messages = mysqli_query($conn, $getMessages);

        ?>
     
      <?php
        while ($msg = mysqli_fetch_assoc($messages)) {
          # code...
        
        ?>

          <div class="tweet-content">
            <strong><?= $msg['messageid'];?></strong>
            <p> <?=$msg['message']; ?></p>
          </div>

          <?php
          }}
          ?>
          <div class="tweet-content">
            <strong>John Doe</strong>
            <p>This is a sample tweet. #coding #twitterclone</p>
          </div>
          
          <div class="tweet-content">
            <strong>John Doe</strong>
            <p>This is a sample tweet. #coding #twitterclone
              woooooooooooooooow hogs Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vero commodi laborum eum laudantium ab unde earum debitis maxime voluptatum quis. Fugit eos dolorum velit nemo quae doloribus corporis qui accusamus.
            </p>
          </div>

          <div class="tweet-content">
            <strong>John Doe</strong>
            <p>This is a sample tweet. #coding #twitterclone
              woooooooooooooooow hogs Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vero commodi laborum eum laudantium ab unde earum debitis maxime voluptatum quis. Fugit eos dolorum velit nemo quae doloribus corporis qui accusamus.
            </p>
          </div>
        </div>
      </div>
        <!-- Additional tweets go here -->
    

        <div class="leftcol">
          <h1>Roaler</h1>
          <button class="leftbutton">Home</button>
          <button class="leftbutton">Search</button>
          <button class="leftbutton">Explore</button>
          <button class="leftbutton">Inbox</button>
          <button class="leftbutton">Profile</button>
          <button class="leftbutton">Settings</button>
        </div>

        <div class="rightcol">
          <div class="profile-box">
            <div class="profile-name">John Doe</div>
            <div class="profile-profession">Software Developer</div>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam vel quae id aperiam sequi. Nesciunt similique quasi laudantium, explicabo cupiditate earum iusto nam ullam corporis ipsam dolores, nisi nobis veniam.</p>
        
        <a href="login.html">
          <button>logout</button>
        </a>
        
        </div>



      <footer>
      <form id="sendMesg">
        <input type="text" class="chat" name="chat1" id="chat1">
        <button class="sendbutton" type="submit" name="sendbutton1">Send AJAX</button>
        </form>
        
      </footer>





<?php

if (isset($_POST['sendbutton'])) {
  # code...

  $chat = $_POST['chat'];
  $userid = 1;

  echo $chat;

  $addmesg = "insert into messages(message, userid) values ('$chat' , $userid);";
  
  mysqli_query($conn, $addmesg);

  //header("Refresh: 1");

 

}
?>

<script>
  document.getElementById('sendMesg').addEventListener('submit', getMesg);

  function getMesg(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var chatInput = document.getElementById('chat1').value; // Get the input value

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'roaler.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Set the request header

    xhr.onload = function() {
      if (this.status === 200) {
        console.log(chatInput); // Log the response from the server
      }
    };

    // Send the chat input as data
    xhr.send('chat1=' + chatInput);
  }
</script>



</body>
</html>
