<?php

class UseLocalObject {

    private string $full_path;

    /**
     * Set the @property full_path
     * @param string $objName
     */
    public function __construct($objName) {
        $this->full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;
    }


    /**
     * Insert a records in Objects
     * @param array[] $datas
     * @return bool|int
     */
    public function insert(array ...$datas): bool|int {
        $all_datas = unserialize(file_get_contents($this->full_path));
        $arr_cols = array_keys($all_datas['cols']);

        if(is_array($datas)) {
            foreach($datas as $data) {

                $tuple = [];
                foreach($data as $dk => $dv) {
                    $tuple[$arr_cols[$dk]] = $dv;
                }

                $all_datas['tuples'][] = $tuple;
            }
        }

        return file_put_contents($this->full_path, serialize($all_datas));
    }

    
    public function update() {
        
    }

    public function delete() {
        
    }


    /**
     * @method View all datas in associative array
     * @return array<array>|bool
     */
    public function view(): bool|array {

        if(file_exists($this->full_path)) {
            
            $data = unserialize(file_get_contents($this->full_path));
            $cols =  $data['cols'];
            $tuples = $data['tuples'];

            $final_res = [];
            foreach($tuples as $tk => $tv) {
                $res = [];
                foreach($tv as $tupleKey => $tupleVal) {
                    $res[$cols[$tupleKey]] = $tupleVal;
                }

                $final_res[] = $res;
            }

            return $final_res;
        }

        return false;
    }


    /**
     * Describe datas GUI table format
     * @return bool|string
     */
    public function describe(): bool|string {

        if(file_exists($this->full_path)) {
            
            $data = unserialize(file_get_contents($this->full_path));
            if($data) {

                $cols =  $data['cols'];
                $tuples = $data['tuples'] ?? [];

                $output = "<table>";
                // table header
                $output .= "<thead><tr>";
                foreach($cols as $ck => $cv) {
                    $output .= "<th>".$cv."</th>";
                }
                $output .= "</tr></thead>";

                // table body
                if(count($tuples) > 0) {
                    $output .= "<tbody>";
                    foreach($tuples as $tk => $tv) {
                        $output .= "<tr>";
                        foreach($cols as $ck => $cv) {
                            $output .= "<td>".($tv[$ck] ?? "-")."</td>";
                        }
                        $output .= "</tr>";
                    }
                    $output .= "</tbody>";
                }

                // table footer
                $output .= "<tfoot><tr>";
                foreach($cols as $ck => $cv) {
                    $output .= "<th>".$cv."</th>";
                }
                $output .= "</tr></tfoot>";
                $output .= "</table>";

                return $output;
            }
        }
        
        return false;
    }


    public function where(array $condition): viewFilter {
        return new viewFilter($condition);
    }

}