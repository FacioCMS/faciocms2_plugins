<?php
    class fcmsanalytics extends fcms_plugin {
        public function getConfig(): array {
            return [
                "name" => "FacioCMS analytics",
                "version" => "0.1.0",
                "useInUserpage" => true
            ];
        }
        
        public function onAdminPanelStart(): int {
            $db = getDatabaseConnection();
            $query = "CREATE TABLE IF NOT EXISTS analytics_entry (
                `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `ip_address` text NOT NULL,
                `entry_date` text NOT NULL,
                `link` text NOT NULL
            );";

            $db->query($query);
            include 'statistics.php';

            return 1; // Status
        }

        public function onUserRequestWebsite(): void {
            $db = getDatabaseConnection();

            $ip_address = $_SERVER['REMOTE_ADDR'];
            $entry_date = date("j.n.Y");

            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $link = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            $query = "INSERT INTO analytics_entry VALUES ('', '$ip_address', '$entry_date', '$link')";
            $db->query($query);
        }
    }