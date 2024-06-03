<?php
include 'header.php';
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
        Home
      </header>

      <div class="centre">
        <div class="Roll" id="Roll" style="margin-bottom: 90px;">
        </div>
      </div>
        <!-- Additional tweets go here -->


        <div class="leftcolumn">
          <h1>Roaler</h1>
          <!-- <button class="leftbutton">Home</button>
          <button class="leftbutton" id="searchMenu">Search</button>
          <button class="leftbutton" onclick="window.location.href='explore.php'">Explore</button>
          <button class="leftbutton" onclick="window.location.href='inbox.php?id=<?=$_SESSION['id']?>'">Inbox</button>
          <button class="leftbutton" onclick="window.location.href='profile.php?id=<?=$_SESSION['id']?>'">Profile</button>
          <button class="leftbutton">Settings</button> -->
        </div>

        <div class="rightcol">

          

          <div class="profile-box" onclick="window.location.href = 'profile.php?id=<?=$_SESSION['id']?>'">
            <div class="profile-name"><?php
            echo $_SESSION['name'];
            ?>
          </div>
            <div>
            <img src="images/blank-profile-picture-973460_960_720.webp" alt="" id="profilepic" class="mainpagepp">  
            <p class="profile-profession">Software Developer</p>
          </div>
            <p class="bio">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam vel quae id aperiam sequi. Nesciunt similique quasi laudantium, explicabo cupiditate earum iusto nam ullam corporis ipsam dolores, nisi nobis veniam.</p>
        </div>
        
          <p style="margin-left: 20px;">You might like</p>
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
        <textarea name="chat1" id="chat" class="chat"></textarea>
        <button class="sendbutton" type="button" name="sendbutton1" id="sendMessage">
          <img src="images/send_24dp_FILL0_wght300_GRAD0_opsz24 (1).png" alt="" style="width: 35px;">
        </button>
        </form>
        
      </footer>

    <script>
        var chat = document.getElementById('chat');
        var sendButton = document.getElementById('sendMessage');
        var Roll = document.getElementById('Roll');
        var searchcolumn = document.getElementById('searchcolumn');
        id = <?=$_SESSION['id'];?> ;

        
        var searchButton = document.getElementById('searchMenu');
        var search = document.getElementById('search');


        sendButton.addEventListener('click', sendMessage);

        // search.addEventListener('click', searchProfiles);

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

        // function searchProfiles(){
        //  // console.log("so u wanna search?");
        //   var searchQuery = {};
        //   let id = <?= $_SESSION['id']?>

        //   var profileToSearch = document.getElementById('searchbar').value;

        //   console.log(profileToSearch);

        //   searchQuery.query = profileToSearch;
        //   searchQuery.rtype = 'search';


        //   xhr = new XMLHttpRequest();

        //   xhr.open('POST', 'processing.php', true);

        //   xhr.onload = function(){
        //     if (this.status == 200) {
        //       //console.log(this.responseText);
        //       var resp = JSON.parse(this.responseText);
        //       console.log(resp);
        //       // //callback(resp);
        //       // html2 = '';

        //       // resp.forEach(element2 => {
        //       // html2+= `<a href="profile.php?id=${element2.userid}"> <p>${element2.name}           
        //       // </p></a>`;
        //       });

        //   document.getElementById('searchresults').innerHTML= html2;

        //     }
        //   }

        //   xhr.send(JSON.stringify(searchQuery));

        //   //var searchResults = sendAJAX(searchQuery);
        //   //console.log(searchResults);
        // }

        function sendAJAX(objtosend) {

          xhr = new XMLHttpRequest();

          xhr.open('POST', 'processing.php', true);

          xhr.onload = function(){
            if (this.status == 200) {
              //console.log(this.responseText);
              //var resp = JSON.parse(this.responseText);
              // console.table(JSON.parse(this.responseText));
              //callback(resp);

              work(JSON.parse(this.responseText))

            }
          }

          xhr.send(JSON.stringify(objtosend));
          //return resp;
          
        }


        // searchButton.addEventListener('click', function(){

        //   if (searchcolumn.style.left == "250px") {
        //     searchcolumn.style.left = "-300px";
        //   }

        //   else{
        //     searchcolumn.style.left = "250px";
        //   }
        // })

        function sendMessage(){
            var msg = chat.value;
            console.log(msg);

          

            if (msg.trim() === '') {
              console.log("empty msg box")
            }

            else{

          



            var msgdata = {};
    
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

                    console.log("msg sent");
                    renderMessages(messageJSON);

                }
            }

            xhr.send(JSON.stringify(msgdata));
            
          }


          chat.value = '';

        }

        //logout
 
        function renderMessages(messageArray) {
            // alert(messageArray);

            // for(i in messageArray){
            //     console.log(i+'next');
            // }

            html = '';

            
            // console.table(messageArray)

            messageArray.slice().reverse().forEach(element => {
                // console.log(messageArray.image);

                //  console.table(element)

            html+=`<div class="tweet-content" onclick = "window.location.href = 'profile.php?id=${element.userid}' " >
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


        function work(obj){
          console.table(obj)

          if (obj['ptype'] === 'config') {
            

            document.querySelector('.bio').textContent = obj[0].bio
            document.querySelector('.profile-profession').textContent = obj[0].username
            document.querySelector('.mainpagepp').src = "images/"+ obj[0].image

          }



          
        }
    
        console.log(id)

        config = {id: id, rtype: 'config'}
        sendAJAX(config)


        
    </script>
</body>
</html>