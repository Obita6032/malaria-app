<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Admin
{
    private $pdo;

    public function __construct( PDO $pdo) 
    {
        $this->pdo = $pdo;
    }

    public function createUser($firstName,$lastName,$county,$access_level,$password,$email)
    
    {  // Check if the Email already exists in the table
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM members WHERE email = :email");
        $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkStmt->execute();

        $rowCount = $checkStmt->fetchColumn();
        if ($rowCount > 0) {
           // Month already exists, handle the situation accordingly
           echo "This User already exists";
        }else{
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO members (first_name, last_name, county, access_level, password, email) VALUES (?, ?, ?, ?, ?, ?)";        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $county, $access_level, $hashedPassword, $email]);

        echo "user created successfulllly";
        }
}


    public function getUsers()
    {
        $sql = "SELECT * FROM members";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function updateUser($id, $first_name, $last_name, $county, $access_level, $password, $email)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE members SET first_name=?, last_name=?, county=?, access_level=?, password=?, email=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$first_name, $last_name, $county, $access_level, $hashedPassword, $email, $id]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM members WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>


