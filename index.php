<?php require_once("./inc/autoload.php"); ?>
<style>
    body {
        padding: 0;
        margin: 0;
        margin-top: 15px;
        margin-left: 15px;
    }
    table {
        color: #333;
        background: white;
        border: 1px solid grey;
        font-size: 12pt;
        border-collapse: collapse;
    }
    table thead th,
    table tfoot th {
        color: #777;
        background: rgba(0,0,0,.1);
    }
    table th,
    table td {
        padding: .5em;
        border: 1px solid lightgrey;
    }
</style>

<?php
/***
 * Project Name = Local Storage
 * Project Description = Local storage database
 */


// Initialize the setup
/**
 * Data Definition Language
 * 
 * @property LocalObject $obj
 * - This property contains the schema manipulating or data defining methods.
 * 
 * @method lists() - @return bool|string
 * @method create() - @return bool|string
 * @method delete() / remove() - @return bool
 * @method rename() - @return bool|string
 * @method alter() - @return bool|string
 * @method truncate() - @return bool
 * @method describe() - @return bool|string
 * @method use() - @return UseLocalObject
 * 
 */
$storage = new LocalStorage();

/* Lists all objects */
// $lists = $storage->obj->lists();
// echo $lists;


/* Create object */
// $create_obj = $storage->obj?->create("postssss", ["id", "title", "description", "permalink"]);
// var_dump($create_obj);


/* Delete Object */
// $del_obj = $storage->obj?->delete("posts1");
// $del_obj = $storage->obj?->remove("postssss");
// var_dump($del_obj);


/* Rename Object */
// $rename_obj = $storage->obj?->rename("customers", "users");
// var_dump($rename_obj);


/* Alter Object */
// $alt_obj_1 = $storage->obj?->alter("posts", "add", ["id", "first_name", "last_name", "city", "industry", "website"]);
// var_dump($alt_obj_1);
// $alt_obj_2 = $storage->obj?->alter("posts", "add", "permanent address", "first_name");
// var_dump($alt_obj_2);

// var_dump($storage->obj?->alter("posts", "modify", ["modified_date" => "modification_date"]));

// $rem_obj_1 = $storage->obj?->alter("posts", "remove", ["permanent address", "first_name"]);
// var_dump($rem_obj_1);
// $rem_obj_2 = $storage->obj?->alter("posts", "remove", "city", "industry");
// var_dump($rem_obj_2);


/* Truncate Object */
// var_dump($storage->obj?->truncate("users"));


/* Describe Object */
// echo $storage->obj->describe("users");




/**
 * Data Manipulation Language
 * 
 * @method insert() - @return bool|int
 * 
 * @method describe() - Returns all records with GUI table format
 * @return bool|string
 * 
 */
$users = $storage->obj?->use("users");

/* Always first column value is unique [pending] */
// var_dump($users->insert(["0003", "vetri", "suriya", "vellore"], ["0004", "virat", "kohli", "delhi"]));


/* Update Record */
// var_dump($users->update());


/* Delete Record */
// var_dump($users->delete());


/* View Method return associative array value */
// var_dump($users->view());



/* Desribe datas with GUI Format */
// echo ($users->describe());

