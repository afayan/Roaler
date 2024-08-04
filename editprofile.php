<?php
include "header.php";

$id = "";

if (isset($_GET["id"])) {
    # code...
    $id = $_GET["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="roaler3.css">

</head>
<body style="background-color: grey; margin-left: 250px;
display:flex;
flex-direction:row;
">

<div style="margin: 100px; display:flex; flex-direction:column;">
    <h1 style="
    font-weight:10;
    height: 68px;
    text-align: center;
    font-size: 40px;
    text-align: left; 
    padding:0px;
    margin:0px  ;
    margin-top:30px;

    ">Username</h1>
    <input type="text" id="newUsername" class="changeProfileInput" >

    <h1 style="
    
    font-weight:10;
    height: 68px;
    text-align: center;
    font-size: 40px;
    text-align: left;
    margin:0px ; 
    margin-top:30px;
  
    ">Name</h1>
    <input type="text" id="newName"  class="changeProfileInput">

    <h1 style="
    font-weight:10;
    text-align: center;
    font-size: 40px;
    text-align: left;
    margin:0px  ;
    margin-top:30px;

   
    ">Bio</h1>
    <textarea name="bio" id="bio" class="changeProfileInput" rows="5"></textarea>
    <button id="save" class="signupText">Save changes</button>


</div>

<div style="margin: 100px; display:flex; flex-direction:column;">
<h1 style="
    font-weight:10;
    height: 68px;
    text-align: center;
    font-size: 40px;
    text-align: left;
    margin:0px  ;
    margin-top:30px;

  
    ">Upload profile pic</h1>
<img src="images/blank-profile-picture-973460_960_720.webp" class="profilepicLarge" id="changeProfpic" alt="">
    <input type="file" id="getProfilePic" >


</div>
    


</body>
</html>

<script>


    var request = {}

    request.rtype = 'profile'
    request.id = <?=$id?>


    xhr = new XMLHttpRequest()

    xhr.open("POST", "processing.php", true)

    xhr.onload = function() {

        //setting the default params
        if (this.status === 200) {
            console.table(JSON.parse(this.responseText))

            res = JSON.parse(this.responseText)

            document.getElementById('newUsername').value = res[0].username
            document.getElementById('newName').value = res[0].name
            document.getElementById('bio').value = res[0].bio
            document.getElementById('changeProfpic').src = "images/"+res[0].image

            // document.getElementById('bio').value = res[0].bio
        }
    }

    xhr.send(JSON.stringify(request))    
    
    



    document.getElementById('save').addEventListener('click', function() {
        fileGiven = false

        //saving new details
        newUsername = document.getElementById('newUsername').value
        console.log(newUsername)

        
        fileInfo = document.getElementById('getProfilePic').files[0]
        console.table(fileInfo)
       

        var changeprofile = {}

        changeprofile.newUname = newUsername
        changeprofile.newName = document.getElementById('newName').value
        changeprofile.newBio = document.getElementById('bio').value
        changeprofile.rtype = 'editProfile'
        changeprofile.id = <?=$id?>;


        if (fileInfo) {
            changeprofile.image = fileInfo.name
            saveImage()

        }

        else{
            changeprofile.image = 'no'
        }

        
        console.table(changeprofile)


        xhr = new XMLHttpRequest()

            xhr.open("POST", "processing.php", true)

            xhr.onload = function() {
                if (this.status === 200) {
                    console.log(this.responseText)

                    if (this.responseText) {
                        alert("Changes saved")
                    }

                    else{
                        alert("username already taken")
                    }
                }
            }

            xhr.send(JSON.stringify(changeprofile))  
            
            
    })

    function saveImage(){
        console.log("save image function")

        const file =  document.getElementById('getProfilePic').files[0]
        const formData = new FormData()
        formData.append("file", file)

        fetch('uploadImage.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }
</script>