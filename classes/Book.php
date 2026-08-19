<?php
require_once "Db.php";

class Book extends Db {
    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
    }

    /**
     * Fetch all bookings with related data from services table
     * @return array Array of bookings with client, keeper, service, and plan details
     */
    public function fetch_all_bookings() {
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
                        c.cl_email,
                        c.cl_phone,
                        k.keeper_fname,
                        k.keeper_lname,
                        k.kp_email,
                        k.kp_phone,
                        sc.service_categories_name,
                        sc.service_description,
                        sp.plan_name,
                        sp.plan_desc
                    FROM services s
                    LEFT JOIN clients c ON s.client_id = c.client_id
                    LEFT JOIN keepers k ON s.keeper_id = k.keeper_id
                    LEFT JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                    LEFT JOIN service_plans sp ON s.plan_id = sp.plan_id
                    ORDER BY s.created_at DESC";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching all bookings: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch bookings for a specific client
     * @param int $client_id The client ID
     * @return array Array of bookings for the client
     */
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
                        k.keeper_fname,
                        k.keeper_lname,
                        k.kp_phone,
                        sc.service_categories_name,
                        sc.service_description,
                        sp.plan_name,
                        sp.plan_desc
                    FROM services s
                    LEFT JOIN keepers k ON s.keeper_id = k.keeper_id
                    LEFT JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                    LEFT JOIN service_plans sp ON s.plan_id = sp.plan_id
                    WHERE s.client_id = :client_id
                    ORDER BY s.created_at DESC";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching client bookings: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch bookings for a specific keeper
     * @param int $keeper_id The keeper ID
     * @return array Array of bookings for the keeper
     */
    public function fetch_keeper_bookings($keeper_id) {
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
                        c.cl_phone,
                        c.cl_email,
                        sc.service_categories_name,
                        sc.service_description,
                        sp.plan_name,
                        sp.plan_desc
                    FROM services s
                    LEFT JOIN clients c ON s.client_id = c.client_id
                    LEFT JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                    LEFT JOIN service_plans sp ON s.plan_id = sp.plan_id
                    WHERE s.keeper_id = :keeper_id
                    ORDER BY s.created_at DESC";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':keeper_id', $keeper_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching keeper bookings: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a single booking by ID
     * @param int $service_id The service/booking ID
     * @return array|false Booking data or false if not found
     */
    public function get_booking_by_id($service_id) {
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
                        c.cl_email,
                        c.cl_phone,
                        k.keeper_fname,
                        k.keeper_lname,
                        k.kp_email,
                        k.kp_phone,
                        sc.service_categories_name,
                        sc.service_description,
                        sp.plan_name,
                        sp.plan_desc
                    FROM services s
                    LEFT JOIN clients c ON s.client_id = c.client_id
                    LEFT JOIN keepers k ON s.keeper_id = k.keeper_id
                    LEFT JOIN service_categories sc ON s.service_cate_id = sc.service_cate_id
                    LEFT JOIN service_plans sp ON s.plan_id = sp.plan_id
                    WHERE s.service_id = :service_id";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching booking by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update booking status
     * @param int $service_id The service/booking ID
     * @param string $status New status (pending, Done, Cancelled)
     * @return bool True on success, false on failure
     */
    public function update_booking_status($service_id, $status) {
        try {
            // Validate status against enum values
            $allowed_statuses = ['pending', 'Done', 'Cancelled'];
            if(!in_array($status, $allowed_statuses)) {
                error_log("Invalid status: " . $status);
                return false;
            }
            
            $sql = "UPDATE services SET status = :status WHERE service_id = :service_id";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error updating booking status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancel a booking
     * @param int $service_id The service/booking ID
     * @return bool True on success, false on failure
     */
    public function cancel_booking($service_id) {
        return $this->update_booking_status($service_id, 'Cancelled');
    }

    /**
     * Create a new booking
     * @param array $data Booking data (keeper_id, service_cate_id, client_id, plan_id, service_date, service_time, service_address)
     * @return int|false The new booking ID or false on failure
     */
    public function create_booking($data) {
        try {
            $sql = "INSERT INTO services 
                    (keeper_id, service_cate_id, client_id, plan_id, service_date, service_time, service_address, status) 
                    VALUES 
                    (:keeper_id, :service_cate_id, :client_id, :plan_id, :service_date, :service_time, :service_address, 'pending')";

            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':keeper_id', $data['keeper_id'], PDO::PARAM_INT);
            $stmt->bindParam(':service_cate_id', $data['service_cate_id'], PDO::PARAM_INT);
            $stmt->bindParam(':client_id', $data['client_id'], PDO::PARAM_INT);
            $stmt->bindParam(':plan_id', $data['plan_id'], PDO::PARAM_INT);
            $stmt->bindParam(':service_date', $data['service_date'], PDO::PARAM_STR);
            $stmt->bindParam(':service_time', $data['service_time'], PDO::PARAM_STR);
            $stmt->bindParam(':service_address', $data['service_address'], PDO::PARAM_STR);

            if($stmt->execute()) {
                return $this->dbconn->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            error_log("Error creating booking: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get booking statistics
     * @return array Statistics for bookings
     */
    public function get_booking_stats() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) as completed,
                        SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
                    FROM services";
            
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting booking stats: " . $e->getMessage());
            return [
                'total' => 0,
                'pending' => 0,
                'completed' => 0,
                'cancelled' => 0
            ];
        }
    }

    /**
     * Count bookings for a specific keeper
     * @param int $keeper_id The keeper ID
     * @return int Number of bookings
     */
    public function count_keeper_bookings($keeper_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM services WHERE keeper_id = :keeper_id";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':keeper_id', $keeper_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch(PDOException $e) {
            error_log("Error counting keeper bookings: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Count bookings for a specific client
     * @param int $client_id The client ID
     * @return int Number of bookings
     */
    public function count_client_bookings($client_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM services WHERE client_id = :client_id";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch(PDOException $e) {
            error_log("Error counting client bookings: " . $e->getMessage());
            return 0;
        }
    }
}
?>