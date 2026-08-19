<?php
    require_once "Db.php";

    class Service extends Db
    {
        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function add_service($service_name,$service_desc){
           try{
             $sql = "INSERT INTO  service_categories(service_categories_name,service_description ) VALUES(?,?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$service_name,$service_desc]);
            $id = $this->dbconn->lastInsertId();
            if($id > 0){
                return true;
            }else{
                return false;
            }
           }catch(PDOException $e){
            return $e->getMessage();
           }

        }

        public function fetch_services(){
           try{
             $sql = "SELECT * FROM service_categories";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $services;
           }catch(PDOException $e){
            return $e->getMessage;
           }
        }

         public function get_serviceid($id){
            try{
                $sql = "SELECT * FROM service_categories WHERE service_cate_id =?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$id]);
                $d = $stmt->fetch(PDO::FETCH_ASSOC);
                return $d;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function update_service($id, $service_name, $service_desc){
            try{
                $sql = "UPDATE service_categories SET service_categories_name = ?, service_description = ? WHERE service_cate_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$service_name, $service_desc, $id]);
                return $stmt->rowCount() >= 0;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function delete_service($id){
            try{
                $sql = "DELETE FROM service_categories WHERE service_cate_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->rowCount() > 0;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

         public function add_service_plan($plan,$desc){
           try{
             $sql = "INSERT INTO  service_plan(plan_name,plan_desc ) VALUES(?,?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$plan,$desc]);
            $id = $this->dbconn->lastInsertId();
            if($id > 0){
                return true;
            }else{
                return false;
            }
           }catch(PDOException $e){
            return $e->getMessage();
           }

        }


         public function fetch_service_plan(){
           try{
             $sql = "SELECT * FROM service_plan";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $services;
           }catch(PDOException $e){
            return $e->getMessage;
           }
        }

        public function get_plan($id){
            try{
                $sql = "SELECT * FROM service_plan WHERE plan_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function update_plan($id, $plan_name, $plan_desc){
            try{
                $sql = "UPDATE service_plan SET plan_name = ?, plan_desc = ? WHERE plan_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$plan_name, $plan_desc, $id]);
                return $stmt->rowCount() >= 0;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function delete_plan($id){
            try{
                $sql = "DELETE FROM service_plan WHERE plan_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->rowCount() > 0;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function manage_bookings(){
            try {
                $sql = "SELECT s.service_id, s.status, s.service_date, s.service_time, s.service_address,
                               c.client_fname, c.client_lname, c.cl_phone,
                               k.keeper_fname, k.keeper_lname, k.kp_phone,
                               sc.service_categories_name,
                               sp.plan_name
                        FROM services s
                        LEFT JOIN clients c ON s.client_id = c.client_id
                        LEFT JOIN keepers k ON s.keeper_id = k.keeper_id
                        LEFT JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                        LEFT JOIN service_plan sp ON s.plan_id = sp.plan_id
                        ORDER BY s.created_at DESC";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error loading admin subjects: " . $e->getMessage());
                return [];
            }
        }

        public function update_booking_status($service_id, $status){
            try {
                $allowed_statuses = ['pending', 'Done', 'Cancelled'];
                if (!in_array($status, $allowed_statuses)) {
                    return false;
                }

                $sql = "UPDATE services SET status = ? WHERE service_id = ?";
                $stmt = $this->dbconn->prepare($sql);
                return $stmt->execute([$status, $service_id]);
            } catch (PDOException $e) {
                error_log("Error updating booking status: " . $e->getMessage());
                return false;
            }
        }

         

    }









?>