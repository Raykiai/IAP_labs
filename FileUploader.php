<?php


class FileUploader
{
    private $target_directory = "uploads/";
    public $target_file;
    private $size_limit = 50000; // File size in bytes (50kB)
    private $uploadOk = false;
    private $file_original_name;
    private $file_type;
    private $file_size;
    private $final_file_name;

    /**
     * @return bool
     */
    public function isUploadOk()
    {
        return $this->uploadOk;
    }


    public function uploadFile()
    {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $this->uploadOk = true;
        }
        $this->target_file = $this->target_directory . basename($_FILES["fileToUpload"]["name"]);

        $this->fileAlreadyExists($this->target_directory);
        $this->fileSizeIsCorrect();
        $this->fileTypeIsCorrect();

        if ($this->uploadOk == false) {

        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->target_file)) {
                echo "Image uploaded <br>";
            } else {
                echo "Upload failed<br>";
            }
        }
    }

    public function fileAlreadyExists($target_directory)
    {
        $target_file = $target_directory . basename($_FILES["fileToUpload"]["name"]);
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $this->uploadOk = false;
        }
    }

    public function savePathTo()
    {

    }

    public function moveFile()
    {

    }

    public function fileTypeIsCorrect()
    {
        $imageFileType = strtolower(pathinfo($this->target_file, PATHINFO_EXTENSION));
//        echo "fkghfoghfog".$imageFileType;
//        die();
        if(($imageFileType != "jpg") && ($imageFileType != "png") && ($imageFileType != "jpeg")
            && ($imageFileType != "gif") ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $this->uploadOk = false;
        }
    }

    public function fileSizeIsCorrect()
    {
        if ($_FILES["fileToUpload"]["size"] > $this->size_limit) {
            echo "Sorry, your file is too large.";
            $this->uploadOk = false;
        }
    }
}