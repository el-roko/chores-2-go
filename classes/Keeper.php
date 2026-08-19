<?php
require_once "Db.php";


class Keeper extends Db
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

    public function get_keeper_byid($id){
        try{
            $sql = "SELECT * FROM keepers WHERE keeper_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data; 
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function keeper_login($email,$password){
        try{
            $sql = "SELECT * FROM keepers WHERE kp_email = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if($data){
                    $stored_pass = $data["kp_password"];
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
            $e->getMessage();
        }
    }

    public function check_kpemail($email){
        try{
            $sql = "SELECT * from keepers WHERE kp_email =? ";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($data){
                    return "<div class='alert alert-danger text-center'> Email already exist use another</div>";
                }else{
                    return "<div class='alert alert-success text-center'> Email available</div>";
                }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function register_keeper($firstname,$lastname,$email,$phone,$password){
        $hash = password_hash($password,PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO keepers(keeper_fname,keeper_lname, kp_email, kp_phone, kp_password) VALUES(?,?,?,?,?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt-> execute([$firstname,$lastname,$email,$phone,$hash]);
            $id = $this->dbconn->lastInsertId();
            return $id;
        }catch(PDOException $e){
            echo $e->getMessage();
            //return false;
        }
    }

     public function update_profile($fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$st,$lga,$id){
           try{
                $sql = "UPDATE keepers SET keeper_fname=?,keeper_lname=?,keeper_gender=?,keeper_dateofbirth=?,kp_phone=?,kp_email=?,kp_address=?,kp_marital=?,state_id=?,local_garea_id=? WHERE keeper_id=?";
                $stmt = $this->dbconn->prepare($sql);
                $res = $stmt->execute([$fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$st,$lga,$id]);
                //return $res;
                     if($res == true) {
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
                $sql = "UPDATE  keepers SET kp_img =? WHERE keeper_id =?";
                $stmt = $this ->dbconn->prepare($sql);
                $res = $stmt->execute([$filename,$id]);
                // return $res;
                return $stmt->rowCount() > 0;
            }catch(PDOException $e){
                return $e->getMessage();
                //return false;
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
    
        $sql = "SELECT kp_password,status FROM keepers WHERE keeper_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$id]);
        $rsp = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$rsp){
            return "User not found";
        }
            if($rsp['status'] === "blocked"){
            return "Your account is blocked. Contact support.";
        }

        if(!password_verify($oldPassword, $rsp["kp_password"])){
            return "Incorrect current password";
        }

      
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        
        $sql = "UPDATE keepers SET kp_password = ? WHERE keeper_id = ?";
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


public function get_keeper(){
        try{
            $sql = "SELECT * FROM keepers";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data; 
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function show_origin($id){
        try{
            $sql = "SELECT keepers.keeper_id, state.state_name, lga.lga_name FROM keepers JOIN state ON keepers.state_id = state.state_id JOIN lga ON keepers.local_garea_id = lga.lga_id WHERE keeper_id =?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            // return $->getMessage();
            return false;
        }
    }

    public function insert_kp_services($cate_id,$plan_id,$keeper_id){
        try{
             $checkSql = "SELECT COUNT(*) FROM keepers_services 
                     WHERE cate_id = ? AND plan_id = ? AND keeper_id = ?";
        $checkStmt = $this->dbconn->prepare($checkSql);
        $checkStmt->execute([$cate_id, $plan_id, $keeper_id]);
        $exists = $checkStmt->fetchColumn();

        if ($exists > 0) {
            return "duplicate"; // already exists, treat as success
        }
            $sql = "INSERT INTO keepers_services (cate_id,plan_id,keeper_id) VALUES(?,?,?)";
            $stmt = $this->dbconn->prepare($sql);
             $res = $stmt->execute([$cate_id,$plan_id,$keeper_id]);
               return $res;
        }catch(PDOException $e){
            return $e->getMessage();
            //return false;
        }
    }

    public function fetch_kp_services($id){
                try{
                    $sql = "SELECT keepers_services.keepers_services_id,service_categories.service_categories_name,service_plan.plan_name  FROM keepers_services JOIN service_categories ON keepers_services.cate_id=service_categories.service_cate_id JOIN service_plan ON keepers_services.plan_id=service_plan.plan_id WHERE keeper_id= ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$id]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }catch(PDOException $e){
                //return $e->getMessage();
                 return false;
            }
        }

        public function delete_service($serviceId, $keeperId){
                try {
                    $sql = "DELETE FROM keepers_services WHERE keepers_services_id = ? AND keeper_id = ?";
                    $stmt = $this->dbconn->prepare($sql);
                    $stmt->execute([$serviceId, $keeperId]);
                    return $stmt->rowCount() > 0;
                } catch(PDOException $e){
                    return false;
                }
            }

            public function fetch_kp_bookings($keeperId){
                try{
                    $sql = "SELECT services.status,services.created_at,services.service_id, clients.client_fname, clients.client_lname, service_categories.service_categories_name, service_plan.plan_name, services.service_date, services.service_time, services.service_address FROM services JOIN clients ON services.client_id = clients.client_id JOIN service_categories ON services.service_cate_id = service_categories.service_cate_id JOIN service_plan ON services.plan_id = service_plan.plan_id WHERE services.keeper_id = ?";
                    $stmt = $this->dbconn->prepare($sql);
                    $stmt->execute([$keeperId]);
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $res;
                }catch(PDOException $e){
                    //return $e->getMessage();
                     return false;
                }
            }




    /**
     * Update booking status
     * @param int $service_id The service/booking ID
     * @param string $status New status (pending, Done, Cancelled)
     * @return bool True on success, false on failure
     */
   public function update_booking_status($service_id, $status, $keeper_id) {
    try {
        $allowed_statuses = ['waiting', 'pending', 'done', 'cancelled'];
        if(!in_array($status, $allowed_statuses)) {
            error_log("Invalid status: " . $status);
            return false;
        }
        
        $sql = "UPDATE services SET status = :status WHERE service_id = :service_id AND keeper_id = :keeper_id";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->bindParam(':keeper_id', $keeper_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch(PDOException $e) {
        error_log("Error updating booking status: " . $e->getMessage());
        return false;
    }
}

    /**
     * Get booking statistics for a keeper
     * @param int $keeper_id The keeper ID
     * @return array Statistics for bookings
     */
   public function get_keeper_booking_stats($keeper_id) {
    try {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'waiting' THEN 1 ELSE 0 END) as waiting,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) as done,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
                FROM services 
                WHERE keeper_id = :keeper_id";
        
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':keeper_id', $keeper_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error getting keeper booking stats: " . $e->getMessage());
        return [
            'total' => 0,
            'waiting' => 0,
            'pending' => 0,
            'done' => 0,
            'cancelled' => 0
        ];
    }
}


   




}

// $s = new Keeper;
// $or = $s->show_origin(1);
// var_dump($or);








?>