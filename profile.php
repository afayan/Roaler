<?php

include_once "header.php";
$id = "";

if (isset($_GET["id"])) {
    # code...
    $id = $_GET["id"];
}
// echo $id;

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">

</head>
<body style="margin-left: 250px;">
    <div id="top">
        <img id="profilePicLarge" class="profilepiclarge" src="images/blank-profile-picture-973460_960_720.webp" alt="profilepic">
        <div style="display: flex; flex-direction:column; width:500px">
            <h3 id="usernameTag" style="padding-left: 60px; padding-right: 100px"></h3>
            <h3 id="followerCount">Following</h2>
            <h1 id="nameTag" style="padding-left: 60px;">Name</h1>
            <p id="bio" style="padding-left: 60px;">hey hey</p>
        </div>
        
        <button id="follow">add Friend</button>
    </div>
    <div id="middle">
        <p style="padding: 20px; font-size:large; margin:0px; background-color:#FF5757">Posts</p>
    </div>
    <div id="bottom">
        <div id="messagesbyprofile" style="display: flex; flex-direction:column;">
        </div>
    </div>
    
</body>

<script>

    myProfileOrNot = false

    getProfileInfo();
    checkFriend(<?=$id?>,<?=$_SESSION['id']?>);

    function checkFriend(u1, u2) {

        var check = {}

        check.user1 = u1
        check.user2 = u2
        check.rtype = "checkFriends"

        xml = new XMLHttpRequest()

        xml.open("POST", "processing.php", true)

        xml.onload = function(){
            if (this.status === 200) {
                console.log(this.responseText)
                
                if (this.responseText) {
                    document.getElementById('follow').textContent = "added";
                    // addFriendButton.
                }

                else if(!this.responseText && u1 === u2){
                    console.log("Same guy")
                    document.getElementById('follow').textContent = "edit profile";
                    myProfileOrNot = true
                }
            }
        }

        xml.send(JSON.stringify(check))
    }

    function getProfileInfo() {
        var profile = {};
        
        profile.id = <?=$id?>;
        profile.rtype = 'profile';

        console.log(profile);

        xhr = new XMLHttpRequest();

          xhr.open('POST', 'processing.php', true);

          xhr.onload = function(){
            if (this.status == 200) {
           
              //console.log(this.responseText);

              profileInfo = JSON.parse(this.responseText);
              console.log(profileInfo);


              setInfo(profileInfo);
            }
          }

          xhr.send(JSON.stringify(profile));
    }


    function setInfo(data) {
        //set all details
        console.table(data)
        document.getElementById('nameTag').innerHTML = data[0].name;
        document.getElementById('usernameTag').innerHTML = data[0].username;
        // document.getElementById('profilepiclarge').src = "images/"+data[0].image;
        document.getElementById('profilePicLarge').src = "images/"+data[0].image;
        document.getElementById('bio').innerHTML = data[0].bio;
        document.getElementById('followerCount').textContent = data.friendCount[0].friendsNo + " friends"


        html = '';
        data.messages.forEach(element => {
            //console.log(element.message);
            html+=`<div class="tweet">${element.message}</div>`

        });

        document.getElementById('messagesbyprofile').innerHTML = html;
        console.log(profileInfo.messages);
    }

    var addFriendButton = document.getElementById('follow');
    
    addFriendButton.addEventListener('click',addFriend);
    

    function addFriend() {

        if (myProfileOrNot) {
            console.log("This is mee")

            window.location.href = 'editprofile.php?id=<?=$_SESSION['id'];?>'
        }

        else{

      
        console.log("hello");
        afreq = {};
        afreq.task = 'add';
        afreq.user1 = '<?=$id?>';
        afreq.user2 = '<?=$_SESSION['id']?>';


        if (addFriendButton.textContent === "add Friend") {
            addFriendButton.textContent = "added";
            //add friend
            afreq.rtype = 'addfriend';


        } else {
            addFriendButton.textContent = "add Friend";
            afreq.rtype = 'unFriend';

        }


        console.log(afreq);



        xhr = new XMLHttpRequest();

        xhr.open('POST', 'processing.php', true);

        xhr.onload = function(){
        if (this.status == 200) {
            //console.log(this.responseText);

            // profileInfo = JSON.parse(this.responseText);
            console.log(this.responseText);


            // setInfo(profileInfo);
        }
        }

        xhr.send(JSON.stringify(afreq));

    }
    }
</script>
</html>

