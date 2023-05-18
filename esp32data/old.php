<?php


$sql = "CREATE TABLE IF NOT EXISTS `demo`.`DIEMCACHLY` ( `MaDiemCachLy` VARCHAR(6) NOT NULL PRIMARY KEY ,
                                           `TenDiemCachLy` VARCHAR(10) NOT NULL ,
                                           `DiaChi` VARCHAR(10) NOT NULL ,
                                           `SucChua` INT(6) UNSIGNED NOT NULL ) ENGINE = InnoDB;";
             $query=mysqli_query($connect,$sql);    
            //echo $_SESSION['favcolor'];
            $sqlCD = "CREATE TABLE IF NOT EXISTS `demo`.`CONGDAN` (  `MaCongDan` VARCHAR(6) NOT NULL PRIMARY KEY ,
                                             `TenCongDan` VARCHAR(15) NOT NULL ,
                                             `GioiTinh` BOOLEAN NOT NULL ,
                                             `NamSinh` DATE NOT NULL, 
                                             `NuocVe` VARCHAR(10) NOT NULL, 
                                             `MaDiemCachLy` VARCHAR(6) NOT NULL,
                                             CONSTRAINT FK_MDCL FOREIGN KEY (MaDiemCachLy)
                                             REFERENCES DIEMCACHLY(MaDiemCachLy)
                                              ) ENGINE = InnoDB;";

              $queryCD=mysqli_query($connect,$sqlCD);
              $_POST['GT']=0;
?>



<!DOCTYPE html>
<div style='width:25%;'>
<form style='border: 1px solid #555;'  method='post' action='endterm.php'>
      Mã điểm cách ly: <input type='input' name='MDCL' placeholder='Mã điểm cách ly' value=''><br><br>
      Tên điểm: <input type='input' id='TD' name='TD' placeholder='Tên điểm' value=''><br><br>
      Địa chỉ: <input type='input' name='DC' placeholder='Địa chỉ'><br><br>
      Sức chứa: <input type='input' name='SC' placeholder='Sức chứa'><br><br>  
      <input type='submit' id='smit' name='Submit' value='Thêm'  ><br><br>
</form>
</div>

<div style='width:25%;'>
<form style='border: 1px solid #555;'  method='post' action='#' onsubmit='onformsubmmit();'>
      Mã công dân: <input type='input' name='MCD' placeholder='Mã công dân'><br><br>
      Tên công dân: <input type='input' name='CD' placeholder='Tên công dân'><br><br>
      Giới tính: <input type='checkbox' name='GT' value='1'><br><br>
      Năm sinh: <input type='date' name='NS'><br><br>
      Nước về: <input type='input' name='NV'><br><br>
      Tên điểm cách ly: <select id='mySelect' name='cdtdcl' >
      <?php
            $sqlsel = "SELECT TenDiemCachLy FROM DIEMCACHLY ";
            // $querysqlsel = mysqli_query($connect,$sqlsel);
            $tmp=0 ;
            $arr = [];
             if ($result = mysqli_query($connect, $sqlsel)) {
                   while ($row = mysqli_fetch_array($result)) {
      
                       echo "<option value='".$row['TenDiemCachLy']."'>".$row['TenDiemCachLy']. "</option>" ;
                       array_push($arr,$row['TenDiemCachLy']);
                       $tmp++;
                   }
               }
      ?>
      </select><br><br>
      <input type='Submit' value='Thêm' name='Submit1' ><br><br>
      </form>
      </div>

      <div>
      <table border="1" cellspacing='1'><tr><th>STT</th><th>Tên công dân</th><th>Giới tính</th><th>Năm sinh</th>
      <th>Nước về</th><th>Chức năng</th></tr>
      <?php 
      $sql5 = "SELECT *  FROM CONGDAN";
      
      if ($result5 = mysqli_query($connect, $sql5)) {
            $i=1;
            while ($row = mysqli_fetch_array($result5)) {
                  if($row['GioiTinh']==1)
                  {
                        $gender='Nam';
                  }else
                  {
                        $gender = 'Nữ';
                  }
                  
                  echo "<tr id='".$row['MaCongDan']."'><td>$i</td> <td>" .$row['TenCongDan']."</td> <td>" .$gender."</td>
                        <td>" .$row['NamSinh']. "</td> <td>" .$row['NuocVe']. "</td>
                         <td style='display:flex;'>
                         <a href='/endterm.php?id=".$row['MaCongDan']."'>View</a><form method='post' action='#''>
                         <input type='hidden' value='" . $row['MaCongDan'] . "' name='deletecongdan'>
                         <input type='submit' name='submit4' class='deletecongdan' value='DELETE'></form>
                         </form>
                        </td></tr>";
                  $i++;
            }
        }
      ?>

    </table>
    <br><br>
    </div>
      </div>
</html>


<?php
//                                                  UPDATE

if(empty($_GET['id'])==0)
{
echo "<div  style='width:25%;'>";
      $sql10 = "SELECT * FROM CONGDAN WHERE MaCongDan='".$_GET['id']."'";
      if ($resultsel = mysqli_query($connect, $sql10)) {
            while ($row = mysqli_fetch_array($resultsel)) {
                  $tmpcl = $row['MaDiemCachLy'];
      echo "<form style='border: 1px solid #555;'  method='post' action='#'>
      Mã công dân: <input type='input' name='MCD' placeholder='Mã công dân' value='".$row['MaCongDan']."'><br><br>
      Tên công dân: <input type='input' name='CD' placeholder='Tên công dân'  value='".$row['TenCongDan']."'><br><br>";
      if($row['GioiTinh']==1){
            echo     "Giới tính: <input type='checkbox' name='GT' value='1' checked><br><br>";
      }
      else{
            echo     "Giới tính: <input type='checkbox' name='GT' value='0' ><br><br>";
      }
 echo     "Năm sinh: <input type='date' name='NS'  value='".$row['NamSinh']."'><br><br>
      Nước về: <input type='input' name='NV' value='".$row['NuocVe']."' ><br><br>";



  $sql17 = "SELECT TenDiemCachLy FROM DIEMCACHLY WHERE MaDiemCachLy='$tmpcl'";       
       if ($result17 = mysqli_query($connect, $sql17)) {
              while ($row = mysqli_fetch_array($result17)) {
                   echo "Tên điểm cách ly: <select id='mySelect' name='cdtdcl'>
                        <option value='".$row['TenDiemCachLy']."'>".$row['TenDiemCachLy']. "</option> ";
              }
          }
       $sql11 = "SELECT TenDiemCachLy FROM DIEMCACHLY WHERE MaDiemCachLy != '$tmpcl' ";       
        if ($result11 = mysqli_query($connect, $sql11)) {
              while ($row = mysqli_fetch_array($result11)) {
                   echo "<option value='".$row['TenDiemCachLy']."'>".$row['TenDiemCachLy']. "</option>" ;
              }
          }

 echo "</select><br><br>";
      }
}
 echo "<input type='Submit' value='Update' name='Update' ><br><br>
      </form>";
echo "</div>";
}
echo "</html>";


if(isset($_POST['Update'])&&($_POST['Update']=="Update"))
{
      $CDid = $_POST['MCD'];
      
      $CDname = $_POST['CD'];
      $CDgt = $_POST['GT'];
      if($_POST['GT']==1)
      {
            $CDgt = $_POST['GT'];
      }
      else{
            $CDgt = 0;
      }
      $CDns = $_POST['NS'];
      $CDnv = $_POST['NV'];
      $CDcl = $_POST['cdtdcl'];
      $sqlfk = "SELECT MaDiemCachLy FROM DIEMCACHLY WHERE TenDiemCachLy = '$CDcl'";
      
      if ($resultcd = mysqli_query($connect, $sqlfk)) {
            while ($row = mysqli_fetch_array($resultcd)) {
                  $CDcl =  $row['MaDiemCachLy'];
                 
            }
        }

       
      $sqlinsertcd =  "UPDATE  `CONGDAN` SET MaCongDan = '$CDid' , TenCongDan = '$CDname' ,GioiTinh = '$CDgt',
      NamSinh = '$CDns' ,NuocVe = '$CDnv', MaDiemCachLy = '$CDcl' WHERE MaCongDan = $CDid " ;
      $queryinsertcd=mysqli_query($connect,$sqlinsertcd);  
        
      
}

?>

<?php
if (isset($_POST['submit4']) && $_POST['submit4'] == "DELETE") {
    $deletecongdan = $_POST["deletecongdan"];
    
    $str = "DELETE FROM CONGDAN WHERE MaCongDan = '$deletecongdan'";
    if ($resultdl = mysqli_query($connect, $str)) {
          echo "Xoa duoc roi";      
          exit();    
      }
      
}

?>




<?php
//INSERT ĐIỂM CÁCH LY
if(isset($_POST['Submit'])&&($_POST['Submit']=="Thêm"))
{
    $CLid = $_POST['MDCL'];
    $CLname = $_POST['TD'];
    $CLdc = $_POST['DC'];
    $CLsc = $_POST['SC'];
   
   $sqlinsert =  "INSERT INTO `DIEMCACHLY` (`MaDiemCachLy`,`TenDiemCachLy`,`DiaChi`, `SucChua`) VALUES ('$CLid','$CLname','$CLdc','$CLsc')";
   $queryinsert=mysqli_query($connect,$sqlinsert);  
   

}

//insert CD
if(isset($_POST['Submit1'])&&($_POST['Submit1']=="Thêm"))
{     
      $CDid = $_POST['MCD'];
      $CDname = $_POST['CD'];
      $CDgt = $_POST['GT'];
      if($_POST['GT'] == 1)
      {
            $CDgt = $_POST['GT'];
      }
      else{
            $CDgt = 0;
      }
      $CDns = $_POST['NS'];
      $CDnv = $_POST['NV'];
      $CDcl = $_POST['cdtdcl'];
      $sqlfk = "SELECT MaDiemCachLy FROM DIEMCACHLY WHERE TenDiemCachLy = '$CDcl'";
      
      if ($resultcd = mysqli_query($connect, $sqlfk)) {
            while ($row = mysqli_fetch_array($resultcd)) {
                  $CDcl =  $row['MaDiemCachLy'];
                 
            }
        
        }

       
      $sqlinsertcd =  " INSERT IGNORE INTO `CONGDAN` (`MaCongDan`,`TenCongDan`, `GioiTinh`,`NamSinh`,`NuocVe`, `MaDiemCachLy`) 
      VALUES ('$CDid','$CDname',' $CDgt','$CDns','$CDnv','$CDcl' )";
        //unset($_POST['Submit1']);
      $queryinsertcd=mysqli_query($connect,$sqlinsertcd); 

}

mysqli_close($connect); 
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.deletecongdan').click(function () {
                var row = $(this).closest('tr');
                var macongdan = $(this).closest('tr')[0].id;
                 alert(macongdan);
                $.ajax({
                    type: 'POST',
                    url: 'endterm.php',
                    data: { deletecongdan: macongdan },
                    success: function (data) {
                        alert(macongdan);
                        $("#"+ macongdan).remove();
                        location.reload();
                        
                    }
                });
            });
        });

        function onformsubmmit()
        {
            alert("hahah");
            location.reload();
        }
        </script>