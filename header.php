<?php
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">

</head>
<body>
<div id="searchcolumn">
          <h1>Search</h1>
          <input type="search" id="searchbar">
          <button id="search">Search</button>
          <div class="searchresults" id="searchresults" style="margin-top: 10px;">

          </div>
        </div>


<div id="settings">
  <h1>Settings</h1>
  <button id="ep" class="settingsButtons" onclick="window.location.href='editprofile.php?id=<?=$_SESSION['id'];?>'" >Edit profile</button>
  <button id="logout" class="settingsButtons">Logout</button>

</div>


<div class="leftcol">
          <img src="images/roalerLogo.png" alt="" style="width: 90px; margin:20px ; border-radius:20px"> 
          <button class="leftbutton" onclick="window.location.href='home.php'">Home</button>
          <button class="leftbutton" id="searchMenu">Search</button>
          <button class="leftbutton" onclick="window.location.href='explore.php'">Explore</button>
          <button class="leftbutton" onclick="window.location.href='inbox.php?id=<?=$_SESSION['id']?>'">Inbox</button>
          <button class="leftbutton" onclick="window.location.href='profile.php?id=<?=$_SESSION['id']?>'">Profile</button>
          <button class="leftbutton" id="settingsButton">Settings</button>
        </div>
<script>
        var searchcolumn = document.getElementById('searchcolumn');
        var searchButton = document.getElementById('searchMenu');
        var search = document.getElementById('search');
        search.addEventListener('click', searchProfiles);
       
        searchButton.addEventListener('click', function(){
            if (searchcolumn.style.left == "250px") {
            searchcolumn.style.left = "-400px";
            }

            else{
            searchcolumn.style.left = "250px";
            }
        })

        var settingsButton = document.getElementById('settingsButton');
        // settingsButton.addEventListener('click', searchProfiles);
       
        settingsButton.addEventListener('click', function(){
            if (settings.style.left == "250px") {
              settings.style.left = "-400px";
            }

            else{
              settings.style.left = "250px";
            }
        })

        function searchProfiles(){
         // console.log("so u wanna search?");
          var searchQuery = {};

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
              html2+= `<div class="searchedProfiles" onclick="window.location.href = 'profile.php?id=${element2.userid}' ">
              <img src="images/${element2.image}" alt="" class="profilePicSmall">
              <p>${element2.name}</p>
            </div>`;
              });

          document.getElementById('searchresults').innerHTML= html2;

            }
          }

          xhr.send(JSON.stringify(searchQuery));

          //var searchResults = sendAJAX(searchQuery);
          //console.log(searchResults);
        }


        document.getElementById('logout').addEventListener('click',  function(){
         
          window.location.href = 'login.php';
        })




        

</script>
</body>
</html>