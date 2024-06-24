<?php
include 'header.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roaler</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">
    <link rel="stylesheet" href="roaler3.css">

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
          <button class="leftbutton" onclick="window.location.href='inofile</button>
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
          <img src="icons/sendLarge.png" alt="" style="width: 35px;">
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
        document.addEventListener('keydown', event => {
          console.log(event)
          if (!event.shiftKey && (event.key === "Enter")) {
            sendMessage()
          }
        })

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

            html = '';

            messageArray.slice().reverse().forEach(element => {
                // console.log(messageArray.image);

                // console.log(element);

                //  console.table(element)
                // console.log(typeof(element.userid)+","+id)

            if ( parseInt(element.userid) === id) {

              console.log("same")

              html+=`<div class="tweet-content"  >
            <strong class = "message-info" onclick = "window.location.href = 'profile.php?id=${element.userid}' "> 
            <img src="images/${element.image}" alt="prfilepic" class = "profilePicSmall">
            ${element.name}  <span class="usernameTag">@${element.username}</span></strong>
            <p  class= "tweetText">
            ${element.message}
            </p>

            <div class = "dropdown"> 
              <button class = "msgInfoButton">
                i
              </button>
              
              <div class = "msgOptions">
                <button class = "msgButtons" onclick = "displayInfo(${element.messageid}, 'delete');" >Delete</button>
                <button class = "msgButtons" onclick = "displayInfo(${element.messageid}, 'reply');" >Reply</button>  
                <button class = "msgButtons">Report</button>  
                <button class = "msgButtons">More</button>  
              </div>
            </div>
            
        
            </div>`;  
            }
            else{
              html+=`<div class="tweet-content"  >
            <strong class = "message-info" onclick = "window.location.href = 'profile.php?id=${element.userid}' "> 
            <img src="images/${element.image}" alt="prfilepic" class = "profilePicSmall">
            ${element.name}  <span class="usernameTag">@${element.username}</span></strong>
            <p  class= "tweetText">
            ${element.message}
            </p>

            <div class = "dropdown"> 
              <button class = "msgInfoButton">
                i
              </button>
              
              <div class = "msgOptions">
                <button class = "msgButtons" onclick = "displayInfo(${element.messageid}, 'reply');" >Reply</button>  
                <button class = "msgButtons">Report</button>  
                <button class = "msgButtons">More</button>  
              </div>
            </div>

            </div>`; 
            }

      
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

          else if(obj['ptype'] === 'reply'){
            
          } 



          
        }
    

        config = {id: id, rtype: 'config'}
        sendAJAX(config)

      async function displayInfo(idToModify, operation){
          console.log(id);
          var d = {}
          d.rtype = 'modifyMessage'
          d.stype = operation
          d.id = idToModify
          d.primaryId = id

          fetch('processing.php', {
            method : "POST",
            body : JSON.stringify(d)
          }).then(function(response){
            return response.json()
          }).then(function(data3){
            renderMessages(data3)
            // console.log(data3);
          })
        }

        
    </script>
</body>
</html>