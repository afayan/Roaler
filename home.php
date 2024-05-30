

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
        session_start();
        echo $_SESSION['loggedUsername'];
        ?>
      </header>

      <div class="centre">
        <div class="Roll" id="Roll" style="margin-bottom: 90px;">
        </div>
      </div>
        <!-- Additional tweets go here -->

        <div id="searchcolumn">
          search
          <input type="search" id="searchbar">
          <button id="search">Search</button>
          <div class="searchresults" id="searchresults"></div>
        </div>
    

        <div class="leftcol">
          <h1>Roaler</h1>
          <button class="leftbutton">Home</button>
          <button class="leftbutton" id="searchMenu">Search</button>
          <button class="leftbutton">Explore</button>
          <button class="leftbutton" onclick="window.location.href='inbox.php?id=<?=$_SESSION['id']?>'">Inbox</button>
          <button class="leftbutton" onclick="window.location.href='profile.php?id=<?=$_SESSION['id']?>'">Profile</button>
          <button class="leftbutton">Settings</button>
        </div>

        <div class="rightcol">

          

          <div class="profile-box">
            <div class="profile-name"><?php
            echo $_SESSION['name'];
            ?>
          </div>
            <div class="profile-profession">Software Developer</div>
            <p class="bio">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam vel quae id aperiam sequi. Nesciunt similique quasi laudantium, explicabo cupiditate earum iusto nam ullam corporis ipsam dolores, nisi nobis veniam.</p>
        </div>
        
          <button onclick="logout()">logout</button>
          <p>You might like</p>
          <div class="trends">
            <div class="recommProfiles">
              <img class="profilePicSmall" src="images/090cf2101b1467c1e547e0e08aa9a965.jpg" alt="">
              <div class="a2">
              <p>SHitman</p>
              <p>bio</p>
              </div>
            </div>
          </div>
        </div>




      <footer>
      <form id="sendMesg">
        <input type="text" class="chat" name="chat1" id="chat">
        <button class="sendbutton" type="button" name="sendbutton1" id="sendMessage">Send</button>
        </form>
        
      </footer>

    <script>
        var chat = document.getElementById('chat');
        var sendButton = document.getElementById('sendMessage');
        var Roll = document.getElementById('Roll');
        var searchcolumn = document.getElementById('searchcolumn');
        
        var searchButton = document.getElementById('searchMenu');
        var search = document.getElementById('search');


        sendButton.addEventListener('click', sendMessage);

        search.addEventListener('click', searchProfiles);

        var defaultRender = {};
        defaultRender.rtype = 'defo';

        var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processing.php',true);
            xhr.onload = function(){
                if (this.status == 200) {
                    // console.log(msgdata);

                    msgs = JSON.parse(this.responseText);
                    //console.log(messageJSON);
                    renderMessages(msgs);

                }
            }

            xhr.send(JSON.stringify(defaultRender));
          //end

        function searchProfiles(){
         // console.log("so u wanna search?");
          var searchQuery = {};
          let id = <?= $_SESSION['id']?>

          var profileToSearch = document.getElementById('searchbar').value;

          console.log(profileToSearch);

          searchQuery.query = profileToSearch;
          searchQuery.rtype = 'search';


          xhr = new XMLHttpRequest();

          xhr.open('POST', 'processing.php', true);

          xhr.onload = function(){
            if (this.status == 200) {
              //console.log(this.responseText);
              var resp = JSON.parse(this.responseText);
              console.log(resp);
              //callback(resp);
              html2 = '';

              resp.forEach(element2 => {
              html2+= `<a href="profile.php?id=${element2.userid}"> <p>${element2.name}           
              </p></a>`;
              });

          document.getElementById('searchresults').innerHTML= html2;

            }
          }

          xhr.send(JSON.stringify(searchQuery));

          //var searchResults = sendAJAX(searchQuery);
          //console.log(searchResults);
        }

        function sendAJAX(objtosend) {

          xhr = new XMLHttpRequest();

          xhr.open('POST', 'processing.php', true);

          xhr.onload = function(){
            if (this.status == 200) {
              //console.log(this.responseText);
              //var resp = JSON.parse(this.responseText);
              console.log(this.responseText);
              //callback(resp);

            }
          }

          xhr.send(JSON.stringify(objtosend));
          //return resp;
          
        }


        searchButton.addEventListener('click', function(){

          if (searchcolumn.style.left == "250px") {
            searchcolumn.style.left = "-300px";
          }

          else{
            searchcolumn.style.left = "250px";
          }
        })

        function sendMessage(){
            var msg = chat.value;
            console.log(msg);
            chat.value = '';

            var msgdata = {};
            // msgdata.sender = '<?php //echo $_SESSION['name'];?>';
            // msgdata.sendermail = '<?php //echo $_SESSION['loggedMail'];?>';
            msgdata.senderid = '<?php echo $_SESSION['id'];?>';
            msgdata.message = msg;
            msgdata.rtype = 'message';


            console.log(msgdata);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processing.php',true);
            xhr.onload = function(){
                if (this.status == 200) {
                    console.log(msgdata);

                    messageJSON = JSON.parse(this.responseText);
                    //console.log(messageJSON);
                    renderMessages(messageJSON);

                }
            }

            xhr.send(JSON.stringify(msgdata));
            

        }

        function logout(){
          var logout = {
            rtype: 'logout'
          }

          sendAJAX(logout);

          window.location.href = 'login.php';
        }

        function renderMessages(messageArray) {
            // alert(messageArray);

            // for(i in messageArray){
            //     console.log(i+'next');
            // }

            html = '';

            
            // console.table(messageArray)

            messageArray.slice().reverse().forEach(element => {
                // console.log(messageArray.image);

                // console.table(element)

            html+=`<div class="tweet-content">
            <strong class = "message-info"> 
            <img src="images/${element.image}" alt="prfilepic" class = "profilePicSmall">

            ${element.name}  <span class="usernameTag">@${element.username}</span></strong>
            <p  class= "tweetText">
            ${element.message}
            </p>
            </div>`;   
            });

            Roll.innerHTML = html;
            return;
        }

        renderTrends()

        function renderTrends() {
          var getTrends = {}
          getTrends.rtype = 'trends'
          getTrends.id = <?= $_SESSION['id']?>


          xhr = new XMLHttpRequest()
          xhr.open('POST', 'processing.php', true)

          xhr.onload = function() {
            if (this.status === 200) {
              console.table(JSON.parse(this.responseText))
              obj = JSON.parse(this.responseText)

              //                 <a href="profile.php?id=${element.userid}">                     </a>




              html = ''

              obj.forEach(element => {

                html += `   
                  <div class="recommProfiles" onclick="window.location.href='profile.php?id=${element.userid}'">
                  <img class="profilePicSmall" src="images/${element.image}" alt="dp">
                  <div class="a2">
                  <p>${element.name}</p>
                  <p>${element.username}</p>
                  </div>
                  </div>
                  `
            } )


              document.querySelector('.trends').innerHTML = html;
             

              // renderTrends(JSON.parse(this.responseText))
            }
          }

          xhr.send(JSON.stringify(getTrends))
        }



        // function renderTrends(obj){
        //   console.table(obj)
        // }
    </script>
</body>
</html>