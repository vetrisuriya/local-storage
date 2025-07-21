<?php

class LocalObject {

    /**
     * Lists returns all objects names if found, not found just return not found error text.
     * @return bool|string
     */
    public function lists(): bool|string {
        $full_path = LocalHelpers::STORAGE_PATH;
        $objs_arr = [];

        $all_objs = scandir($full_path);
        foreach($all_objs as $obj) {
            if($obj != "." && $obj != "..") {
                $obj_info = pathinfo($obj);
                if(".".$obj_info["extension"] === LocalHelpers::EXT) {
                    $objs_arr[] = explode(".", $obj_info["basename"])[0];      
                }
            }
        }

        if($objs_arr) {
            sort($objs_arr);
            $output = "<table>";
            $output .= "<thead><tr><th>Table Name</th></tr>";
            foreach($objs_arr as $obj_k => $obj_v) {
                $output .= "<tr><td>".$obj_v."</td></tr>";
            }
            $output .= "</thead>";
            $output .= "</table>";
        } else {
            $output = "<table>";
            $output .= "<thead><tr><th>Table Name</th></tr>";
            $output .= "<tr><td>No Tables Found</td></tr></thead>";
            $output .= "</table>";
        }

        return $output ?? false;
    }


    /**
     * This method is responsible for create file in storage
     * @param string $objName
     * @param array $cols
     * @return bool|string
     */
    public function create($objName, array $cols): bool|string {
        $full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;

        if(!file_exists($full_path)) {

            $data = [];
            if(is_array($cols)) {
                foreach($cols as $column_key => $column_val) {
                    $data[LocalHelpers::randCol()] = $column_val;
                }
            }

            file_put_contents($full_path, serialize(["cols" => $data]));
            return true;
        } else {

            $error = "Table Name already Exists!";
        }

        return $error ?? false;
    }


    /**
     * Delete Object in Storage
     * @param string $objName
     * @return bool
     */
    public function delete($objName): bool {
        $full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;

        if(file_exists($full_path)) {
            unlink($full_path);

            return true;
        }

        return false;
    }
    public function remove($objName): bool {
        return $this->delete($objName);
    }


    /**
     * Renaming the Object Name
     * @param string $exist
     * @param string $new
     * @return bool|string
     */
    public function rename($exist, $new): bool|string {
        $exist_path = LocalHelpers::STORAGE_PATH."".$exist."".LocalHelpers::EXT;
        $new_path = LocalHelpers::STORAGE_PATH."".$new."".LocalHelpers::EXT;

        if(file_exists($exist_path)) {
            if($new) {
                rename($exist_path, $new_path);

                return true;
            }
        } else {
            $error = "Exist Object not found";
        }

        return $error ?? false;
    }


    /**
     * Altering the objects like create column, modify column and remove column
     * @param string $objName
     * @param string $action [add, modify, remove]
     * @param array $cols
     * @return bool|string
     */
    public function alter($objName, $action, ...$cols): bool|string {
        $full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;
        $error = "";

        if(file_exists($full_path)) {
            $all_datas = unserialize(data: file_get_contents($full_path));


            $data = $all_datas["cols"] ?? [];
            if(is_array($cols)) {
                foreach($cols as $column_key => $column_val) {
                    if(is_array($column_val)) {
                        foreach($column_val as $ck => $cv) {
                            if($action == "add") {
                                if($all_datas) {
                                    if(!in_array($cv, $data)) {
                                        $data[LocalHelpers::randCol()] = $cv;
                                    }
                                } else {
                                    $data[LocalHelpers::randCol()] = $cv;
                                }
                            } elseif($action == "modify") {
                                $exist_col_count = array_keys($data, $ck);
                                $new_col_count = array_keys($data, $cv);

                                if(count($new_col_count) == 0 && count($exist_col_count) <> 0) {                                 
                                    $data[$exist_col_count[0]] = $cv;
                                } elseif(count($exist_col_count) == 0) {
                                    $error = "Column name does not exist";
                                } else {
                                    $error = "Modifying column name already exist";
                                }
                            } elseif($action == "remove") {
                                $exist_col_key = array_keys($data, $cv);

                                if(count($exist_col_key) <> 0) {
                                    unset($data[$exist_col_key[0]]);
                                }
                            }
                        }
                    } else {
                        if($action == "add") {
                            if($all_datas) {
                                if(!in_array($column_val, $data)) {
                                    $data[LocalHelpers::randCol()] = $column_val;
                                }
                            } else {
                                $data[LocalHelpers::randCol()] = $column_val;
                            }
                        } elseif($action == "remove") {
                            $exist_col_key = array_keys($data, $column_val);

                            if(count($exist_col_key) <> 0) {
                                unset($data[$exist_col_key[0]]);
                            }
                        }
                    }
                }

                $all_datas["cols"] = $data;
                file_put_contents($full_path, serialize($all_datas));
                if(!$error) {
                    return true;
                }
            }
        }

        return $error ?? false;
    }


    /**
     * Empty the value records
     * @param string $objName
     * @return bool
     */
    public function truncate($objName, bool $everything=false): bool {
        $full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;

        if(file_exists($full_path)) {
            if($everything) {
                file_put_contents($full_path, "");
            } else {
                $all_datas = unserialize(file_get_contents($full_path));
                $all_datas["tuples"] = [];
                file_put_contents($full_path, serialize($all_datas));
            }

            return true;
        }

        return false;
    }


    /**
     * Schematic view of objects
     * @param string $objName
     * @return bool|string
     */
    public function describe($objName): bool|string {
        $full_path = LocalHelpers::STORAGE_PATH."".$objName."".LocalHelpers::EXT;

        if(file_exists($full_path)) {
            
            $data = unserialize(file_get_contents($full_path));
            if($data) {

                $cols =  $data['cols'];

                $output = "<table>";
                $output .= "<thead><tr><th>".strtoupper($objName)."</th></tr><tr><th>Column Name</th></tr>";
                foreach($cols as $ck => $cv) {
                    $output .= "<tr><td>{$cv}</td></tr>";
                }
                $output .= "</thead>";
                $output .= "</table>";

                return $output;
            }
        }
        
        return false;
    }


    /**
     * This method gives Data Manipulation access
     * @param string $objName
     * @return UseLocalObject
     */
    public function use($objName): UseLocalObject {
        return new UseLocalObject($objName);
    }

}