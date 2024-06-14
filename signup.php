<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roaler Signup</title>
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
    <link rel="icon" href="../roalerLogo.png" type="image/jpeg">

</head>
<body style="display: flex; flex-direction:row ;background-color: #FFDE59;
">

<div class="logo" ></div>



    <form id="inputform" class="signupform">
        <h1 style="margin-top: 0px;">Sign up to Roaler</h1>

        <input type="text" placeholder="name" id="name" class="signupText">
        <input type="password" placeholder="password" id="password" class="signupText">
        <input type="password" placeholder="retype password" id="password2" class="signupText">
        <input type="text" placeholder="unique username" id="username" class="signupText">
        <input type="email" placeholder="email" id="email" class="signupText">
        <button type="button" id="submit"  class="signupText">Create account</button>
        <button type="button" class="signupText" onclick="window.location.href = 'login.php'">Already have an account? Log in</button>

    </form>
</body>
</html>

<script>
    var myform = document.getElementById('inputform');
    var submit = document.getElementById('submit');

    submit.addEventListener('click', sendData)

  


    function sendData(event){

        if (document.getElementById('password').value === document.getElementById('password2').value) {
            
      

  

        var name = document.getElementById('name').value;
        var password = document.getElementById('password').value
        var username = document.getElementById('username').value;
        var email = document.getElementById('email').value

        if (name.trim() === '' || password.trim() === '' || username.trim() === '' || email.trim() === '') {
            console.log("Blank")
        }

        else{

       


        var creds = {
        };

        creds['name'] = name;
        creds['password'] = password;
        creds['username'] = username;
        creds['email'] = email;
        creds['rtype'] = 'signup';
        // console.log("senddata function started "+ name + password);
        // console.log(creds)


        //start sending data by AJAX

        var xhr = new XMLHttpRequest()

        xhr.open('POST', 'processing.php', true);

        xhr.onload = function(){
            if (this.status == 200) {
            console.log(this.responseText)
            alert(this.responseText); 

            }
        }

        xhr.send(JSON.stringify(creds))
    }
    }

    else{
        alert("Passwords do not match, try again")
    }

    }
    
    // submit.addEventListener('click', sendData);

    // var data = [];

    // function sendData(event) {
    //     //var myform = _("inputform");
    //     //var name = document,getElementById('name').value;

    //     event.preventDefault();

    //     var name = document.getElementById('name').value;
    //     var password = document.getElementById('password').value;
    //     var password2 = document.getElementById('password2').value;

    //     console.log('reached functinn')

    //     const data = {
    //         name : name,
    //         password : password
    //     }

    //     console.log(data);

    //     //start sending data to server

    //     var xhr = new XMLHttpRequest()

    //     xhr.open('POST', 'roaler.php', true )

    //     xhr.onload = function() {
    //         if (this.status == 200) {
    //             console.log(this.responseText);
    //         }
    //     }

    //     xhr.send()
    // }
</script>