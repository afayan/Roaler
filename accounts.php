<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
</head>
<body style = "background-color: #FFDE59;
margin-left: 40%;
">

<div style="display: flex; flex-direction:row ;   color: #FF5757;" >
<img src="images/roalerLogo.png" alt="" style="
    width:40px;
    height:40px;
    margin: 10px;
    margin-top: 18px;
    margin-right: 25px;
    border-radius:3px;
    padding:0px;
    font-family:Arial, Helvetica, sans-serif;
  
    ">

   
    <h1 style="padding: 0px;"> Welcome to Roaler  </h1>


</div>

    <h2>Choose account</h2>

    
    <div id="accountsRoll">


    <button class="accounts" value="accname">
        <img src="images/090cf2101b1467c1e547e0e08aa9a965.jpg" alt="" id="profilepic">
        <p>Account name</p>
    </button>
    </div>

    
</body>
</html>

<script>

    var d = {rtype:'accounts'}

    xhr = new XMLHttpRequest()
    xhr.open("POST", 'processing.php', true)

    xhr.onload = function(){
        if (this.status === 200) {
            // console.log(this.responseText)
            users = JSON.parse(this.responseText)
            renderAccounts(users)
        }
    }

    xhr.send(JSON.stringify(d))


    function renderAccounts(users){

        html = ''
        users.forEach(element => {
            html += ` <button class="accounts" mail="${element.email}">
        <img src="images/${element.image}" alt="pp" id="profilepic">
        <p class = "accountName" >${element.username}</p>
        </button>`
        });

        document.getElementById('accountsRoll').innerHTML = html;

        document.querySelectorAll('.accounts').forEach(button => {
            button.addEventListener('click', function() {
                // var email = this.email;
                var loginData = {
                    email: this.getAttribute('mail'),
                    stype: 'direct',
                    rtype: 'directlogin'
                }

                xhr = new XMLHttpRequest()
                xhr.open("POST", 'processing.php', true)

                xhr.onload = function(){
                    if (this.status === 200) {
                        // console.log(this.responseText)
                        if (this.responseText) {
                            // window.location.href = 'home.php';
                            console.table(JSON.parse(this.responseText))
                            rData = JSON.parse(this.responseText)

                            login(rData)

                        }
                    }
                }

                xhr.send(JSON.stringify(loginData))
                console.log(this.getAttribute('mail'))

            })
        })




        function login(rData){
            var loginData = {};

        loginData.email = rData[0].email;
        loginData.password = rData[0].password;
        loginData.stype = 'indirect';
        loginData.rtype = 'login';

        console.log(loginData);

        var xhr = new XMLHttpRequest();

        xhr.open("POST", 'processing.php', true)

        xhr.onload = function(){
            if (this.status === 200) {
                console.log("ajax connected");
                console.log(this.responseText);

                if (this.responseText) {
                    console.log("yaay lets go");
                    window.location.href = "home.php";
                }

                else{
                    document.getElementById('error').innerHTML = "wrong credentials";
                }
            }
        }

        xhr.send(JSON.stringify(loginData));
        }
    }
</script>