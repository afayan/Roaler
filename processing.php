<?php
include "database.php";

//echo "Process reached";

$data = file_get_contents("php://input");


if ($data != "") {
        # code...
        $myData = json_decode($data, true);
    }
$myData = json_decode($data, true);

$type = $myData['rtype'];

switch ($type) {
    case 'login':
        # code...
        //echo "you shuold login";

        
        // header("Location:roaler.php");
            # code...
            $email = $myData['email'];
            $password = $myData['password'];
    
            $login = "select * from users where email = '$email' and password = '$password';";
    
            $return = mysqli_query($conn, $login);
    
    
            if (mysqli_num_rows($return) == 0) {
                # code...
                echo false;
            }
    
            //we have to validate login
    
            else {
                session_start();
                $_SESSION['loggedMail'] = $myData['email'];
    
                $row = mysqli_fetch_assoc($return);
                $_SESSION['loggedUsername'] = $row['username'];
                $_SESSION['id'] = $row['userid'];
                $_SESSION['name'] = $row['name'];
                echo true;
            }
   
        break;

        case 'directlogin':
            # code...

            $email = $myData['email'];
            $q = "select * from users where email = '$email'";
            session_start();
            $_SESSION['loggedMail'] = $myData['email'];

            $a = convertSqliToArray(mysqli_query($conn, $q));
            // $_SESSION['loggedUsername'] = $a['username'];
            // $_SESSION['id'] = $a['userid'];
            // $_SESSION['name'] = $a['name'];
            echo json_encode($a);

            
            break;


    case 'config':
        # code...
        $myId = $myData['id'];
        $q = "select * from users where userid = $myId";
        
        $a  = convertSqliToArray(mysqli_query($conn, $q));
        $a['ptype'] = 'config';

        echo json_encode($a);
        break;

    case 'signup':
        try{
            
            
            $creds = json_decode($data, true);
            echo "dtaaaa given";
            
            $name = $creds['name'];
            $password = $creds['password'];
            $username = $creds['username'];
            $email = $creds['email'];
            //$username = $creds['username'];
            
            echo "Data received: Name - $name, Password - $password";
            
            $insertvals = "insert into users(username, email, name, password, image) values ('$username', '$email','$name', '$password', 'blank-profile-picture-973460_960_720.webp');";
            mysqli_query($conn, $insertvals);
            
        }catch(Exception $e){
            echo "username not unique";
            
            
        }
        break;

    case 'search':
        # code...

        //echo "search right?";

        $toSearch = $myData['query'];
        
        $q = "select * from users where username like '%$toSearch%' or name like'%$toSearch%';";
        $return = mysqli_query($conn, $q);

        echo convertToJSON($return);
        break;


    case 'message':

        //echo "message recieved - " . $myData['message'];
        # code...
        $message = addslashes($myData['message']);
        $userid = $myData['senderid'];
        // $currentUser = $_SESSION['username'];
        // echo $currentUser;

        $insertMessage = "insert into messages(message, userid) values ('$message', $userid);";
        mysqli_query($conn, $insertMessage);

        //echo "inserted into database";

        $showMessages = "select m.messageid, u.userid, u.username, u.name, m.message, u.image from users u, messages m where u.userid = m.userid;";

        // $messagesArray = mysqli_query($conn, $showMessages);

        // $msgArray = [];

        // while ($row = mysqli_fetch_assoc($messagesArray)) {
        //     $msgArray[] = $row;
        // }

        // $messageJSON = json_encode($msgArray);

        // echo $messageJSON;

        echo convertToJSON(mysqli_query($conn, $showMessages));
        break;

    case 'logout':
        # code...
        session_destroy();
        echo "logout";
        break;


    case 'profile':
        # code..
        //echo "profile needed";

        $idreq = $myData['id'];
        $query = "select * from users where userid = '$idreq';";
        $query2 = "select * from messages where userid = '$idreq';";
        $q3 = "select count(*) as friendsNo from friends where id1 = '$idreq' or id2 = '$idreq';";
        //echo convertToJSON(mysqli_query($conn,$query));
        //echo convertToJSON(mysqli_query($conn,$query2));
        $arr1 = mysqli_query($conn, $query);
        $arr2 = mysqli_query($conn, $query2);

        $countFriends = convertSqliToArray(mysqli_query($conn, $q3));
        $new1 = [];
        $new2 = [];

        while ($row = mysqli_fetch_assoc($arr1)) {
            # code...
            $new1[] = $row;
        }

        while ($row = mysqli_fetch_assoc($arr2)) {
            # code...
            $new2[] = $row;
        }

        $new1['messages'] = $new2;
        $new1['friendCount'] = $countFriends;

        echo json_encode($new1);

        break;

    case 'addfriend':
        # code...
        // echo "lets add friend";
        $user1 = $myData['user1'];
        $user2 = $myData['user2'];

        // echo $user1 . $user2;
        mysqli_query($conn, "insert into friends(id1, id2) values ('$user1', '$user2');");

        break;

    case 'unFriend':
        # code...
        $user1 = $myData['user1'];
        $user2 = $myData['user2'];

        // echo $user1 . $user2;
        mysqli_query($conn, "delete from friends where id1 = $user1 and id2 = $user2;");
        break;


    case 'checkFriends':
        # code...
        $user1 = $myData['user1'];
        $user2 = $myData['user2'];
        $q = "select * from friends where (id1 = '$user1' and id2 = '$user2') or (id1 = '$user2' and id2 = '$user1')";

        $arr3 = convertSqliToArray(mysqli_query($conn,$q));

        if (count($arr3) == 0) {
            # code...
            echo false;
            // echo "You are not friends";
        }

        else{
            echo True;
            // echo "you are friends";
        }
        break;

    case 'getFriends':
        # code...
        // echo "Get frinds";
        $u1 = $myData['user1'];
        $u2 = $myData['user2'];

        $qForAll = " select f.id1, u1.name as user1, u2.name as user2, f.id2 from friends f, users u1, users u2 where f.id1 = u1.userid and f.id2 = u2.userid;";
        $qForTargeted = "select * from (select f.id1, u1.name as user1, u2.name as user2, f.id2 from friends f, users u1, users u2 where f.id1 = u1.userid and f.id2 = u2.userid) as tb where tb.id1 = $u1 or tb.id2 = $u2; ";
        
        echo convertToJSON(mysqli_query($conn, $qForTargeted));
        break;

    case 'DM':
        // echo "DM right?";
        # code...

        if ($myData['stype'] === 'new') {
            # code...
            $senderid = $myData['senderid'];
            $recieverid = $myData['recieverid'];
            $dm = addslashes($myData['message']) ;
            $q = "insert into dms(id1, id2, message) values ($senderid,$recieverid, '$dm');";
            mysqli_query($conn, $q);

            $a = "select * from dms where id1 = $senderid and id2 = $recieverid or id1 = $recieverid and id2 = $senderid ;";

            echo convertToJSON(mysqli_query($conn, $a));
        }


        elseif ($myData['stype'] === 'photo') {
            # code...

            $id = $myData['idToGetPhotoFor'];

            $q = "select image from users where userid = '$id'";

            echo convertToJSON(mysqli_query($conn, $q));

        }

        else {
            $senderid = $myData['senderid'];
            $recieverid = $myData['recieverid'];
            $q = "select * from dms where id1 = $senderid and id2 = $recieverid or id1 = $recieverid and id2 = $senderid ;";
            echo convertToJSON(mysqli_query($conn, $q));
        }

        
        break;

    case 'editProfile':
        # code...
        $username = $myData['newUname'];
        $name = $myData['newName'];
        $bio = $myData['newBio'];
        $id = $myData['id'];
        $image = $myData['image'];

        if ($image === 'no') {
            # code...
            $q = "update users set username = '$username', name = '$name', bio = '$bio' where userid = $id; ";
        }

        else{
            $q = "update users set username = '$username', name = '$name', bio = '$bio', image = '$image' where userid = $id; ";
        }


        if (!checkUsername($username,$id , $conn)) {
            # code...
            echo false;
        }

        else{
            mysqli_query($conn, $q);

            echo true;
        }


      
        // $bio =  $myData
        break;


    case 'defo':

        $q = "select m.messageid, u.userid, u.username, u.name, m.message, u.image from users u, messages m where u.userid = m.userid;";
        # code...

        echo convertToJSON(mysqli_query($conn,$q));
        break;

    case 'trends':
        # code...
        $id = $myData['id'];

        $q = "select u.userid, u.username, u.name, u.image, u.bio from users u where u.userid not in (select id1 from friends where id1 = $id or id2 = $id) and u.userid not in (select id2 from friends where id1 = $id or id2 = $id);";

        echo convertToJSON(mysqli_query($conn, $q));
        break;

    case 'uploadMedia':
        # code...

        echo "added media";
        $title = $myData['name'];
        $image = $myData['fileInfo'];
        $type = $myData['type'];
        $url = $myData['url'];

        $q = "insert into media(title, type, image, url) values ('$title', '$type', '$image', '$url');";

        mysqli_query($conn, $q);

        echo true;
        break;

    case 'getMedia':
        # code...
        $q = "select * from media";

        echo convertToJSON(mysqli_query($conn, $q));

        break;

    case 'accounts':
        $q = "select username, image, userid,email from users;";

        echo convertToJSON(mysqli_query($conn, $q));
        break;

    case 'deleteMessage':
        $id = $myData['id'];
        $q = "delete from messages where messageid = $id ;";
        $q2 = "select m.messageid, u.userid, u.username, u.name, m.message, u.image from users u, messages m where u.userid = m.userid;";

        mysqli_query($conn, $q);

        echo convertToJSON(mysqli_query($conn, $q2));

        // echo json_encode(['Hey']);
        break;

    default:
        # code...
        echo "no rtype given";
        break;
}

function convertSqliToArray($sqliobject){
    $ans = [];

    while ($row = mysqli_fetch_assoc($sqliobject)) {
        # code...
        $ans[] = $row;
    }

    return $ans;
}

function convertToJSON($sqli){
    $myArray = [];

    while ($row = mysqli_fetch_assoc($sqli)) {
        # code...
        $myArray[] = $row;
    }

    $arrayJSON = json_encode($myArray);
    return $arrayJSON;
}

function checkUsername($username,$id, $conn){
    $q = "select * from users where username = '$username' and userid != $id; ";

        $return = mysqli_query($conn, $q);

    if (mysqli_num_rows($return) == 0) {
        # code...
        return true;
    }

    else {
        return false; 
    }
}



function checkEmail($email,$id, $conn){
    $q = "select * from users where email = '$email' and userid != $id;";

    $return = mysqli_query($conn, $q);

if (mysqli_num_rows($return) == 0) {
    # code...
    return true;
}

else {
    return false; 
}
}

    ?>