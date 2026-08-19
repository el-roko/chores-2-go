<?php
    require_once "Db.php";

    class Service extends Db
    {
        private $dbconn;


        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function fetch_service_categories(){
            try{
                $sql = "SELECT * FROM service_categories";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }catch(PDOException $e){
                // return $e->getMessage();
                return false;
            }
        }


        public function fetch_service_plan(){
            try{
                $sql = "SELECT plan_id, plan_name FROM service_plan";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
               
                $plans = [];
                foreach ($rows as $row) {
                    $plans[$row['plan_id']] = $row;
                }
                return $plans;
            }catch(PDOException $e){
                // return $e->getMessage();
                return false;
            }
        }

         public function fetch_services(){
           try{
             $sql = "SELECT service_cate_id, service_categories_name FROM service_categories";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             // Key results by ID
                $services = [];
                foreach ($rows as $row) {
                    $services[$row['service_cate_id']] = $row;
                }
                return $services;

           }catch(PDOException $e){
            //return $e->getMessage;
            return false;
           }
        }

        public function get_service_plan_name($id) {
            $plans = $this->fetch_service_plan();
            return $plans[$id]['plan_name'] ?? null;
        }

        public function get_service_category_name($id) {
            $services = $this->fetch_services();
            return $services[$id]['service_categories_name'] ?? null;
        }



        public function fetch_keeper_by_service($categoryId, $planId){
    try {
        $sql = "SELECT keepers.keeper_id, keepers.keeper_fname, keepers.keeper_lname, keepers.keeper_gender, keepers.kp_img, service_categories.service_categories_name, service_plan.plan_name FROM keepers JOIN keepers_services ON keepers.keeper_id = keepers_services.keeper_id JOIN service_categories ON keepers_services.cate_id = service_categories.service_cate_id JOIN service_plan  ON keepers_services.plan_id = service_plan.plan_id WHERE service_categories.service_cate_id = ? AND service_plan.plan_id = ?";
        
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$categoryId, $planId]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    } catch(PDOException $e) {
        return $e->getMessage();
        return false;
    }
}




 // Fetch all messages for a keeper (and optionally a specific client)
public function fetch_messages($keeperId, $clientId = null) {
    $sql = "SELECT * FROM chats WHERE keeper_id = :keeper_id";
    $params = [":keeper_id" => $keeperId];

    if ($clientId !== null) {
        $sql .= " AND client_id = :client_id";
        $params[":client_id"] = $clientId;
    }

    $sql .= " ORDER BY created_at ASC";

    $stmt = $this->dbconn->prepare($sql);

    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    }

    $stmt->execute();

    // Fetch all rows as associative arrays
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Fetch distinct clients who have chatted with this keeper
    public function fetch_chat_clients($keeperId) {
        try {
            $sql = "SELECT DISTINCT c.client_id, c.client_fname, c.client_lname, ch.created_at as last_msg_at FROM chats ch JOIN clients c ON ch.client_id = c.client_id WHERE ch.keeper_id = ? ORDER BY ch.created_at DESC";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$keeperId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    // Insert a new message
    public function send_message($clientId, $keeperId, $message) {
        try {
            if ($this->columnExists('chats', 'sender')) {
                $sql = "INSERT INTO chats (client_id, keeper_id, message, sender, created_at) VALUES (?, ?, ?, ?, NOW())";
                $stmt = $this->dbconn->prepare($sql);
                return $stmt->execute([$clientId, $keeperId, $message, 'keeper']);
            } else {
                $sql = "INSERT INTO chats (client_id, keeper_id, message, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $this->dbconn->prepare($sql);
                return $stmt->execute([$clientId, $keeperId, $message]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function book_service($cl,$kp,$cat,$plan,$date,$time,$add){
            try{
                $sql = "INSERT INTO services (client_id, keeper_id, service_cate_id, plan_id, service_date, service_time, service_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->dbconn->prepare($sql);
                $res = $stmt->execute([$cl,$kp,$cat,$plan,$date,$time,$add]);
                return $res;
            }catch(PDOException $e){
                return $e->getMessage();
                return false;
            }
    }








    }
//      $s = new Service;
//  $or = $s->book_service(10, 3, 1, '2023-10-10', '10:00', '123 Main St');
// var_dump($or);


?>