<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roaler Login</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">
</head>
<body style="display: flex; flex-direction:row;     background-color: #FFDE59;
">

<div class="logo" ></div>

    <form id="inputform" class="signupform">
        <h1>Sign in to Roaler</h1>
        <!-- <input type="text" placeholder="name" id="name" class="signupText"> -->
        <input type="email" placeholder="email" id="email" class="signupText">
        <input type="password" placeholder="password" id="password" class="signupText">
        <!-- <input type="password" placeholder="retype password" id="password2" class="signupText"> -->
        <!-- <input type="text" placeholder="unique username" id="username" class="signupText"> -->
        <button type="button" id="login" class="signupText">Login</button>
        <button type="button" id="loginWithRoaler" class="signupText" onclick="window.location.href='accounts.php'">continue with Roaler</button>
        <button type="button" class="signupText" onclick="window.location.href = 'signup.php'">New? Sign up</button>
        <p id="error"></p>
    </form>
</body>
</html>

<script>
    var reqEmail = document.getElementById('email');
    console.log(reqEmail.value);

    var loginButton = document.getElementById('login');
    loginButton.addEventListener('click', loginFunction)


    function loginFunction(){
        var reqEmail = document.getElementById('email');
        var reqPassword = document.getElementById('password')


        console.log(reqEmail.value); 
        console.log(reqPassword.value);

        var loginData = {};

        loginData.email = reqEmail.value;
        loginData.password = reqPassword.value;
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
</script>