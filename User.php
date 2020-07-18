<?php
  include "Crud.php";
  include "Authenticator.php";
  include_once 'DBConnector.php';
  /**
   *
   */
  class User implements Crud, Authenticator
  {

    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;

    private $username;
    private $password;
    private $timestamp;
    private $offset;

    /**
     * @return mixed
     */
    public function getPassword()
    {
      return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
      $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
      return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
      $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
      return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
      $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
      return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
      $this->offset = $offset;
    }

    function __construct($first_name, $last_name, $city_name, $username, $password, $timestamp, $offset)
    {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->city_name = $city_name;
      $this->username = $username;
      $this->password = $password;
      $this->timestamp = $timestamp;
      $this->offset = $offset;

    }



    // Static constructor
    public static function create()
    {
      $instance = new self();
      return $instance;
    }

    public function isUserExist($con)
    {
      $res = mysqli_query($con, "SELECT username FROM user WHERE username = '$this->username'");
      if ($res->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }
    public function setUserId($user_id)
    {
      $this->user_id = $user_id;
    }

    public function getUserId()
    {
      return $this->user_id;
    }

    public function save($con, $target_file)
    {
      $fn = $this->first_name;
      $ln = $this->last_name;
      $city = $this->city_name;
      $uname = $this->username;
      $timestamp = $this->timestamp;
      $offset = $this->offset;
      $this->hashPassword();
      $pass = $this->password;
      $res = mysqli_query($con, "INSERT INTO user(first_name, last_name, user_city, username, password, image_path, time_stamp, time_zone_offset) VALUES('$fn', '$ln', '$city', '$uname', '$pass', '$target_file', '$timestamp', '$offset')") or die("Error: ". mysqli_error($con));

      return $res;
    }

    public static function readAll($con)
    {
      $res = $con->query("SELECT * FROM user");
      return $res;
    }
    public function readUnique()
    {
      return null;
    }
    public function search()
    {
      return null;
    }
    public function update()
    {
      return null;
    }
    public function removeOne()
    {
      return null;
    }
    public function removeAll()
    {
      return null;
    }

    public function validateForm()
    {
      // Returns true if the values are not empty
      $firstName = $this->first_name;
      $lastName = $this->last_name;
      $city = $this->city_name;

      if ($firstName == "" || $lastName == "" || $city == "") {
        return false;
      }
      return true;
    }


    public function createFormErrorSessions()
    {
      session_start();
      $_SESSION['form-errors'] = "All fields are required.";
    }

    public function hashPassword()
    {
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public static function isPasswordCorrect($username, $password)
    {
      $con = new DBConnector();
      $found = false;
      $res = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: ".mysqli_error($con->conn));

      while ($row =  $res->fetch_assoc()) {
        if (password_verify($password, $row['password']) && $username == $row['username']) {
          $found = true;
        }
      }

      $con->closeDatabase();
      return $found;
    }

    public function login()
    {
      if ($this->isPasswordCorrect()){
        header("Location:private_page.php");
      }
    }

    public static function createUserSession($username){
      session_start();
      $_SESSION['username'] = $username;
    }

    public static function logout()
    {
      session_start();
      unset($_SESSION['username']);
      session_destroy();
      header("Location:lab1.php");
    }
  }

?>
