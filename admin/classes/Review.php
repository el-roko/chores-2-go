<?php
require_once "Db.php"; // 

class Review extends Db{

    private $conn;

    public function __construct(){
     
        $this->conn = $this->connect();
    }

    // Total number of reviews
    public function total_reviews(){
        try {
            $sql = "SELECT COUNT(*) FROM reviews";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch(PDOException $e){
            error_log("Error counting reviews: " . $e->getMessage());
            return 0;
        }
    }

    // Average rating across all reviews (rating is stored as enum '1'-'5', cast to compute avg)
    public function average_rating(){
        try {
            $sql = "SELECT AVG(CAST(rating AS UNSIGNED)) FROM reviews";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $avg = $stmt->fetchColumn();
            return $avg ? (float) $avg : 0.0;
        } catch(PDOException $e){
            error_log("Error averaging ratings: " . $e->getMessage());
            return 0.0;
        }
    }

    // Count of low-rated reviews (1-2 stars), used as a simple "needs attention" stat
    // since there's no status/flag column in this table
    public function total_low_rated(){
        try {
            $sql = "SELECT COUNT(*) FROM reviews WHERE CAST(rating AS UNSIGNED) <= 2";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch(PDOException $e){
            error_log("Error counting low-rated reviews: " . $e->getMessage());
            return 0;
        }
    }

    // Fetch all reviews, joined with the client who wrote them
    
    public function fetch_reviews($filter = null){
        try {
            $sql = "SELECT r.review_id, r.rating, r.messages, r.created_at,
                           CONCAT(c.client_fname, ' ', c.client_lname) AS reviewer_name
                    FROM reviews r
                    LEFT JOIN clients c ON r.client_id = c.client_id";

            if($filter === 'low'){
                $sql .= " WHERE CAST(r.rating AS UNSIGNED) <= 2";
            } elseif($filter === 'high'){
                $sql .= " WHERE CAST(r.rating AS UNSIGNED) >= 4";
            }

            $sql .= " ORDER BY r.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            error_log("Error fetching reviews: " . $e->getMessage());
            return [];
        }
    }

    // Fetch a single review by id, with the same joined reviewer name
    public function get_review($review_id){
        try {
            $sql = "SELECT r.review_id, r.rating, r.messages, r.created_at,
                           CONCAT(c.client_fname, ' ', c.client_lname) AS reviewer_name
                    FROM reviews r
                    LEFT JOIN clients c ON r.client_id = c.client_id
                    WHERE r.review_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$review_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            error_log("Error fetching review: " . $e->getMessage());
            return null;
        }
    }

    // Delete a review
    public function delete_review($review_id){
        try {
            $sql = "DELETE FROM reviews WHERE review_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$review_id]);
            return $stmt->rowCount() > 0;
        } catch(PDOException $e){
            error_log("Error deleting review: " . $e->getMessage());
            return false;
        }
    }
}
