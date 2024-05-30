<?php
echo "processing...";


if (isset($_POST['name'])) {

    $messageRecieved = $_POST['name'];
    echo "message is ". $messageRecieved;
    #echo "fuck";
    # code...
  }

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php ajax</title>
</head>
<body>
    <form id="info">
        <p>Enter your name</p>
        <input type="text" placeholder="name" id="nameinput">
        <button type="submit" name="submit" id="submit">Submit</button>
    </form>



    <script>
        document.getElementById('info').addEventListener('submit', postName);

        function postName(event) {
            event.preventDefault()

            var name = document.getElementById('nameinput').value;
            var params = 'name='+name;

            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'new.php', true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

            xhr.onload = function(){
                if (this.status === 200) {
                    console.log("working" + this.responseText);
                }
            }
            
            xhr.send(params);
        }
    </script>
</body>
</html>