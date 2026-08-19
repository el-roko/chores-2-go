<?php
    require_once "Db.php";

    class Admin extends Db
    {
        private $conn;

        public function __construct(){
            $this->conn = $this->connect();
        }

       

         public function admin_login($email,$password){
            try{
                $sql = "SELECT * FROM admins WHERE admin_email =?";
                $stmt =$this->conn->prepare($sql);
                $stmt->execute([$email]);
                $data= $stmt->fetch(PDO::FETCH_ASSOC);
                
                    if($data){
                        $stored_hash = $data['admin_password'];
                        $chk = password_verify($password,$stored_hash); #confirm
                        
                            if($chk == false){
                                return "invalid password";
                            }else{
                                return $data["admin_id"];
                            }
                    }else{
                        return "Invalid Email";
                    }
                }catch(PDOException $e){
                    // return getMessage();
                    return false;
                }
        }

        public function logout(){
            unset($_SESSION["useronline"]);
            session_destroy();
        }

        public function get_admin_byid($id){
               try{
                 $sql = "SELECT * FROM admins WHERE admin_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$id]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data;
               }catch(PDOException $e){
                    return $e->getMessage();
               }

        }

        public function total_clients(){
             try{
                 $sql = "SELECT count(*) AS total FROM clients";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data["total"];
               }catch(PDOException $e){
                    return $e->getMessage();
               }
        }
        public function total_keepers(){
             try{
                 $sql = "SELECT count(*) AS total FROM keepers";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data["total"];
               }catch(PDOException $e){
                    return $e->getMessage();
               }
        }

        public function fetch_clients(){
            try{
                 $sql = "SELECT * FROM clients";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
               }catch(PDOException $e){
                    return $e->getMessage();
               }
        }


        public function fetch_keepers(){
            try{
                 $sql = "SELECT * FROM keepers";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
               }catch(PDOException $e){
                    return $e->getMessage();
               }
        }

        public function update_client_status($client_id, $status) {
            try {
                $sql = "UPDATE clients SET status = ? WHERE client_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$status,$client_id]);
                return $stmt->rowCount() > 0;
            } catch(PDOException $e) {
                error_log("Error updating client status: " . $e->getMessage());
                return false;
            }
            }

        public function update_keeper_status($keeper_id, $status) {
            try {
                $sql = "UPDATE keepers SET status = ? WHERE keeper_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$status,$keeper_id]);
                return $stmt->rowCount() > 0;
            } catch(PDOException $e) {
                error_log("Error updating keeper status: " . $e->getMessage());
                return false;
            }
            }

       



    }

    // $a = new Admin;
    // $ad = $a->update_client_status(2, "blocked");

    // echo "<pre>";
    //             print_r($ad);
    //         echo "</pre>";


?>