
<?php
class Database {
    private static $con = null;

    private function __construct() {
    }
   
    public static function getConnection() {
        if (self::$con === null) {
            try {
                self::$con = new PDO(
                    "mysql:host=localhost;dbname=dbusuarios", 
                    "root",
                    "Anthony2024",
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) 
                );
            } catch (PDOException $e) {
                exit("Error: " . $e->getMessage()); 
            }
        }
        return self::$con; 
    }




     /* public static function getConnection() {
        if (self::$con === null) {
            try {
                self::$con = new PDO(
                    "mysql:host=192.168.126.15;dbname=dbusuarios", 
                    "rootdos",
                    "javier2024,",
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) 
                    );
                
            } catch (PDOException $e) {
                exit("Error: " . $e->getMessage()); 
            }
          
        }
        return self::$con; 
    }*/

}
?>
