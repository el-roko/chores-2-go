<?php
require_once "Db.php";


class Client extends Db
{
    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
        // print($this->dbconn); to test if connected
    }

    public function logout(){
        unset($_SESSION["useronline"]);
        session_destroy();
    }


    public function get_client(){
        try{
            $sql = "SELECT * FROM clients";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data; 
        }catch(PDOException $e){
          return  $e->getMessage();
        }
    }

    // returns array of client data not just id.
    public function get_client_byid($id){
        try{
            $sql = "SELECT * FROM clients WHERE client_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([(int)$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $e){
           return $e->getMessage();
        }
    }

    public function client_login($email,$password){
            try{
                $sql = "SELECT * FROM clients WHERE cl_email = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$email]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($data){
                        $stored_pass = $data["cl_password"];
                        $check = password_verify($password,$stored_pass);
                            if($check == false){
                                    return "Invalid Password";
                            }else{
                                return $data;
                            }
                    }else{
                        return "Invalid Email";
                    }
            }catch(PDOException $e){
                return $e->getMessage();
            }
    }

    public function check_clemail($email){
        try{
            $sql = "SELECT * FROM clients WHERE cl_email = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($data){
                    return "<div class='alert alert-danger text-center'> Email already exist use another</div>";
                }else{
                    return "<div class='alert alert-success text-center'>Email available</div>";
                }
        }catch(PDOException $e){
           return $e->getMessage();
        }
    }

    public function register_client($firstname,$lastname,$email,$phone,$pass1){
        $hash = password_hash($pass1,PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO clients(client_fname,client_lname, cl_email, cl_phone, cl_password) VALUES(?,?,?,?,?)";
            $stmt = $this->dbconn->prepare($sql);

            $stmt-> execute([$firstname,$lastname,$email,$phone,$hash]);
            $id = $this->dbconn->lastInsertId();
            return $id;
        }catch(PDOException $e){
           // return $e->getMessage();
            return false;
        }
    }

    public function update_profile($fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$st,$lga,$id){
           try{
                $sql = "UPDATE clients SET client_fname=?,client_lname=?,client_gender=?,client_dateofbirth=?,cl_phone=?,cl_email=?,cl_address=?,cl_marital=?,state_id=?,local_garea_id=? WHERE client_id=?";
                $stmt = $this->dbconn->prepare($sql);
                $res = $stmt->execute([$fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$st,$lga,$id]);
                //return $res;
                     if($stmt->rowCount() > 0) {
                        return true; 
                    } else {
                        return false;
                    }
              
           }catch(PDOException $e){
               return $e->getMessage();
           }

    }

     public function update_image($filename,$id){
           try{
             $sql = "UPDATE  clients SET cl_img_url =? WHERE client_id =?";
            $stmt = $this ->dbconn->prepare($sql);
            $res = $stmt->execute([$filename,$id]);
            return $res;
           }catch(PDOException $e){
                return $e->getMessage();
           }
        }


        
     public function fetch_all_state(){
            $sql = "SELECT * FROM state";
            $stmt = $this->dbconn->prepare($sql);
             $stmt->execute();
            $state =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $state;
        }


    public function fetch_lga_by_state($stateId){
            $sql = "SELECT * FROM lga WHERE state_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$stateId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        
   public function update_password($id, $oldPassword, $newPassword){
    try {
    
        $sql = "SELECT cl_password FROM clients WHERE client_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$id]);
        $rsp = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$rsp){
            return "User not found";
        }

        if(!password_verify($oldPassword, $rsp["cl_password"])){
            return "Incorrect current password";
        }

      
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        
        $sql = "UPDATE clients SET cl_password = ? WHERE client_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$hashed, $id]);

        if($stmt->rowCount() > 0){
            return true; 
        } else {
            return "No changes made";
        }

    } catch(PDOException $e){
        return $e->getMessage();
    }
}

    public function show_origin($id){
        try{
            $sql = "SELECT clients.client_id, state.state_name, lga.lga_name FROM clients JOIN state ON clients.state_id = state.state_id JOIN lga ON clients.local_garea_id = lga.lga_id WHERE clients.client_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([(int)$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!$res){
                        return "No records found";
                    }
            return $res;
        }catch(Exception $e){
            // return $e->getmessage();
            return false;
        }
    }
 

   public function fetch_client_bookings($client_id) {
    try {
        $sql = "SELECT 
                    s.service_id,
                    s.client_id,
                    s.keeper_id,
                    s.service_cate_id,
                    s.plan_id,
                    s.service_date,
                    s.service_time,
                    s.service_address,
                    s.status,
                    s.created_at,
                    c.client_fname,
                    c.client_lname,
                    k.keeper_fname,
                    k.keeper_lname,
                    sc.service_categories_name,
                    sp.plan_name
                FROM services s
                INNER JOIN clients c ON s.client_id = c.client_id
                INNER JOIN keepers k ON s.keeper_id = k.keeper_id
                INNER JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                INNER JOIN service_plan sp ON s.plan_id = sp.plan_id
                WHERE s.client_id = :client_id
                ORDER BY s.created_at DESC";

        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching client bookings: " . $e->getMessage());
            return [];
        }
    }


        // Add to Client.php
        public function cancel_booking($service_id, $client_id){
            try{
                $sql = "UPDATE services SET status = 'cancelled' WHERE service_id = ? AND client_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$service_id, $client_id]);
                return $stmt->rowCount() > 0;
            }catch(PDOException $e){
                error_log("Error cancelling booking: " . $e->getMessage());
                return false;
            }
        }

        public function review($id,$rate,$msg){
            try{
                $sql = "INSERT into reviews (client_id,rating,messages) VALUES (?,?,?)";
                $stmt = $this->dbconn->prepare($sql);
                $res = $stmt->execute([$id,$rate,$msg]);
                return $res;
            }catch(PDOException $e){
                return $e->getMessage();
                //return false;
            }
        }


    public function fetch_reviews(){
    try{
        $sql = "SELECT reviews.*, client_fname, client_lname 
                FROM reviews 
                JOIN clients ON reviews.client_id = clients.client_id";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $count = count($data);

        return [
            'reviews' => $data,
            'count'   => $count
        ];
    }catch(PDOException $e){
        return $e->getMessage();
    }
}






 


}


//  $c = new Client;
//  $up = $c->show_origin(12);
//  var_dump($up);





?>