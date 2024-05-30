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
</head>
<body style="background-color: grey; margin-left: 250px;">
    <h1>username</h1>
    <input type="text" id="newUsername">

    <h1>Name</h1>
    <input type="text" id="newName">

    <h1>Bio</h1>
    <textarea name="bio" id="bio"></textarea>

    <h1>Upload profile pic</h1>
    <input type="file" id="getProfilePic">

    <button id="save">Save changes</button>

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
                }
            }

            xhr.send(JSON.stringify(changeprofile))      
    })
</script>