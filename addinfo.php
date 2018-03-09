<html>
<head>
<meta charset="utf-8">
<title>Add new information</title>
</head>
<body>


<script language="javascript">
function refresh(){
    fillin.action = location.href;
    fillin.submit();
}
</script>


<?php
$conn = mysqli_connect("localhost","root","zbw879034","student_47");
if(!$conn){
    die('Could not connect: ' . mysqli_error());
    echo "mysqld connect error!";
}


$nameErr = $schoolErr = $provinceErr = "";
$name = $school = $province = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["name"])){
        $nameErr = "姓名必填";
    } else{
        $name = test_input($_POST["name"]);
    }
    
    if(empty($_POST["school"])){
        $schoolErr = "单位必填";
    } else{
        $school = test_input($_POST["school"]);
    }

    if(empty($_POST["province"])){
        $provinceErr = "请选择省份";
    } else{
        $province = test_input($_POST["province"]);
    }

}


function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return data;
}

?>
<form name= "fillin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
name: <input type="text" name="fname">
<span class="error">* <?php echo $nameErr; ?></span>
<br><br>
age: <input type="text" name="age">
<br><br>
<?php

class SelectList{

    var $select1, $select2;
    var $conn;

    function initDB(){
        $this->conn = mysqli_connect("localhost","root","zbw879034","student_47");
        if(!$this->conn){
            die('Could not connect: ' . mysqli_error());
            echo "mysqld connect error!";
        }
    }

    function createList($name, $value, $title, $count, $select_value, $onchange=FALSE){
        echo $name . ": ";
        // echo "<br>";
        if($onchange == TRUE){
            echo '<select name="' . $name . '" onChange=' . '"refresh()"' . ">";
        } else{
            echo '<select name="' . $name . '">';
        }

        for($i=0;$i<$count;$i++){
            if($value[$i]==$select_value){
                echo "<option value=" . $value[$i] . " selected>" . $title[$i] . "</option>";
            } else{
                echo "<option value=". $value[$i] . ">" . $title[$i] . "</option>";
            }
        }

        echo "</select>";
        echo "<br><br>";
    }

    // change select2 according to the select1_value
    function selectFirst($select_value1){
        $this->select2 = array();
        $this->select2["title"] = array();
        $this->select2["value"] = array();
        $this->select2["count"] = 0;
        // echo "select_value = " . $select_value1 . "<br>";
        $itemArray = mysqli_query($this->conn, "SELECT * FROM school WHERE province=" . $select_value1);
        if(!$itemArray){
            return;
        }
        while($row = mysqli_fetch_array($itemArray)){
            array_push($this->select2["value"], $row["id"]);
            array_push($this->select2["title"], $row["school"]);
            $this->select2["count"]++;
        }
    }


    // data ready for select1 list (province)
    function initList1(){
        $this->select1 = array();
        $this->select1["title"] = array();
        $this->select1["value"] = array();
        $this->select1["count"] = 0;
        $itemArray = mysqli_query($this->conn, "SELECT * FROM province");
        if(!$itemArray){
            return;
        }
        while($row = mysqli_fetch_array($itemArray)){
            array_push($this->select1["title"], $row["province"]);
            array_push($this->select1["value"], $row["id"]);
            $this->select1["count"]++;
        }
    }

    // show the list 1 and list 2
    function showList($arg){
        if(!isset($arg['province'])){
            $arg['province'] = "none";
        }
        if(!isset($arg['school'])){
            $arg['school'] = "none";
        }

        $this->initDB();
        $this->initList1();
        $this->createList("province", $this->select1["value"], $this->select1["title"], $this->select1["count"], $arg["province"], true);
        $this->selectFirst($arg['province']);
        $this->createList("school", $this->select2["value"], $this->select2["title"], $this->select2["count"], $arg["school"]);

    }
}
    
// check whether this submit is executed by user
// if user check the checkbox, the ensure value will be "1"
function isUserSubmit(){
    $q = isset($_POST['ensure'])? htmlspecialchars($_POST['ensure']) : '';
    if($q){
        if($q == "1"){
            return TRUE;
        }
    }
    return FALSE;
}

?>

<?php
    $isUserSubmitted = FALSE;

    $list1 = new SelectList();
    $list1->showList($_POST);

?>
<br><br>

<input type="checkbox" name="ensure[]" value="1"> I agree to fill in this chart. <br>

<input type="submit" value="提交">
</form>
 
</body>
</html>
