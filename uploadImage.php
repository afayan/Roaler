<?php
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
        $filename = $_FILES["file"]["name"];
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = array("jpg", "jpeg", "gif", "png", "txt", "pdf", "docx", "webp");
        if(!in_array($ext, $allowed)) {
            die("Error: Please select a valid file format.");
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Define a custom directory to save the file
        $custom_dir = "images/";
        if(!file_exists($custom_dir)){
            mkdir($custom_dir, 0777, true);
        }

        // Save file to the custom directory
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $custom_dir . $filename)){
            echo "Your file was uploaded successfully.";
        } else{
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        echo "Error: " . $_FILES["file"]["error"];
    }
}
?>