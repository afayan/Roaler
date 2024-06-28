<?php
include_once 'header.php';

$id = "";

if (isset($_GET["id"])) {
    # code...
    $id = $_GET["id"];
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">

</head>
<body style="margin-left: 250px; overflow:hidden">
    <h1 style="padding: 20px;" class="header"><?=$_SESSION['loggedUsername']?>'s inbox</h1>
    <div class="messageContent">
        <div class="friendSection">
           
        </div>
        <div class="chatSection">
            <div style="display: flex; flex-direction:row;" id="chatHeader">

                <img id="profilepic" src="images/090cf2101b1467c1e547e0e08aa9a965.jpg" alt="prof">
                <h1 id="personToDM" style="margin-left: 10px;"> 
                </h1>

            </div>
                

                <div id="blocker"  style="
                position: fixed; 
                height: 100%; 
                top: 67px; 
                right: 0px;
                /* left:546px;  */
                left:35%;
                z-index:9999;     
                background-color: #FF5757;
                ; font-size:70px;">
                    <img src="icons/chat_40dp_FILL0_wght400_GRAD0_opsz40.png" alt=""
                    style="padding-left: 40%;padding-top:20%;">
                    <h1 style="font-size:38px; margin-left:35%; color:white;
                    font-weight:10;
                    
                    ">Start messaging</h1>
                </div>

                <div id="alldms">

                    


                    <div class="dm">Hey</div>
                </div>
                <div id="sendDMBar">
                    <!-- <input type="text" id="DMtoSend" style="padding: 10px;"> -->
                    <textarea name="dm" id="DMtoSend"  rows="2" cols="85"></textarea>
                    <button id="sendDM" style="padding: 10px; margin-top: -90px; margin-left:20px">
                </button>
                </div>
        </div>
    </div>
</body>

    <script>
        user1 = "<?=$id?>";
        user2 = "<?=$_SESSION['id']?>";

        //both are same
        // document.querySelector('.chatSection').style.display = "hidden";

        renderFriends()
        var sender = ""
        var reciever = ""
        var senderid = user2
        var recieverid = 0

    //    const renderFriends = ()=>{

    //         console.log("hell")
    //     }

        document.getElementById('sendDM').addEventListener('click', sendDM)
        
    
        document.addEventListener('keydown', event => {
          if (!event.shiftKey && (event.key === "Enter")) {
            sendDM()
          }
        })
        
        function sendDM() {
            //function to send message
            var DMtoSend = document.getElementById('DMtoSend')
            console.log(DMtoSend.value)


            if (DMtoSend.value.trim() === '') {
                console.log("empty dm")
            }

            else{

            var dmdata = {}
            dmdata.rtype = "DM"
            dmdata.stype = "new"
            dmdata.senderid = senderid
            dmdata.recieverid = recieverid
            dmdata.message = DMtoSend.value

            DMtoSend.value = ""
            // DMtoSend.value =  DMtoSend.value.replace(, '');


            console.log(senderid+" send to "+recieverid);

            xhr = new XMLHttpRequest()

            xhr.open("POST", "processing.php", true)

            xhr.onload = function() {
                if (this.status === 200) {
                    console.table(JSON.parse(this.responseText))

                    renderDMs(JSON.parse(this.responseText))
                }
            }

            console.table(dmdata)
            xhr.send(JSON.stringify(dmdata))
        }
        }

        function renderFriends(){
            console.log("hell");
            var friendsList = {}
            friendsList.rtype = "getFriends";
            friendsList.user1 = user1;
            friendsList.user2 = user2;

            xhr = new XMLHttpRequest()
            xhr.open("POST", "processing.php", true)

            xhr.onload = function(){
                if (this.status === 200) {
                    console.log(user1)
                    console.table(JSON.parse(this.responseText))
                    
                    myFriends = JSON.parse(this.responseText);
                    console.table(myFriends)

                    html = "";
                    myFriends.forEach(element => {

                        if (element.id1 === user1) {
                            html+=`<button class="friend">
                            <p id="name" user = "${element.user2}" userid = ${element.id2}>${element.user2}</p>
                            </button>`;
                        }

                        else{
                            html+=`<button class="friend">
                            <p id="name" user = "${element.user1}" userid = ${element.id1}>${element.user1}</p>
                            </button>`;
                        }                        
                    });
                    document.querySelector('.friendSection').innerHTML = html;

                    
                    document.querySelectorAll('.friend').forEach(button => {
                    button.addEventListener('click', function() {
                        let user = this.querySelector('#name').getAttribute('user');
                        let userid = this.querySelector('#name').getAttribute('userid')
                        openDms(user, userid);
              });
            });
        }                
            }
            xhr.send(JSON.stringify(friendsList))
        }

        function openDms(val, userid) {
            //fucntion to open DM window, and configure DM details
            console.log("clicked "+val);
            console.log("userid "+userid)

            reciever = val;
            recieverid = userid
            document.getElementById('alldms').innerHTML = null

            document.getElementById('blocker').style.display = 'none';


            document.getElementById('personToDM').innerHTML = val

            document.getElementById('chatHeader').onclick = function() {
                    window.location.href = "profile.php?id=" + userid;
                };



            var dmdata = {}
            dmdata.rtype = "DM"
            dmdata.stype = "default"
            dmdata.senderid = senderid
            dmdata.recieverid = recieverid
            // dmdata.message = DMtoSend.value

            DMtoSend.value = ""


            // console.log(senderid+" send to "+recieverid);

            xhr = new XMLHttpRequest()

            xhr.open("POST", "processing.php", true)

            xhr.onload = function() {
                if (this.status === 200) {
                    console.log("openDMS function table: \n")
                    console.table(JSON.parse(this.responseText))

                    renderDMs(JSON.parse(this.responseText))
                }
            }

            console.table(dmdata)
            xhr.send(JSON.stringify(dmdata))    
            
            
            //get the profile pic

            var getP = {}
            getP.rtype = "DM"
            getP.stype = 'photo'
            getP.idToGetPhotoFor = userid

            xhr = new XMLHttpRequest()

            xhr.open("POST", "processing.php", true)

            xhr.onload = function() {
                if (this.status === 200) {
                    tab = JSON.parse(this.responseText)
                    console.table("images/"+ tab)


                    document.getElementById('profilepic').src = "images/"+ tab[0].image

                }
            }

            // console.table(dmdata)
            xhr.send(JSON.stringify(getP))  


        }
     
    
        // function renderFriends2(myFriends){
            
        // }
        
        function renderDMs(listOfDMs) {

            html = ""

            listOfDMs.forEach(element => {
                var classDM
                console.log(element.message)

                if (element.id1 === user2) {
                    classDM = 'dm'
                }

                else{
                    classDM = 'mydm'
                }

                html +=   `<div class="${classDM}">${element.message}</div>`

            })
            var chatContainer = document.getElementById('alldms');
            chatContainer.innerHTML = html

            chatContainer.scrollTop = chatContainer.scrollHeight;

            
        }
            
    </script>
</html>