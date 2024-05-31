<?php
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="roaler.css">
</head>
<body>
<div id="searchcolumn">
          search
          <input type="search" id="searchbar">
          <button id="search">Search</button>
          <div class="searchresults" id="searchresults"></div>
        </div>


<div class="leftcol">
          <h1>Roaler</h1>
          <button class="leftbutton" onclick="window.location.href='home.php'">Home</button>
          <button class="leftbutton" id="searchMenu">Search</button>
          <button class="leftbutton" onclick="window.location.href='explore.php'">Explore</button>
          <button class="leftbutton" onclick="window.location.href='inbox.php?id=<?=$_SESSION['id']?>'">Inbox</button>
          <button class="leftbutton" onclick="window.location.href='profile.php?id=<?=$_SESSION['id']?>'">Profile</button>
          <button class="leftbutton">Settings</button>
        </div>
<script>
        var searchcolumn = document.getElementById('searchcolumn');
        var searchButton = document.getElementById('searchMenu');
        var search = document.getElementById('search');
        search.addEventListener('click', searchProfiles);
       
        searchButton.addEventListener('click', function(){
            if (searchcolumn.style.left == "250px") {
            searchcolumn.style.left = "-300px";
            }

            else{
            searchcolumn.style.left = "250px";
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

</script>
</body>
</html>