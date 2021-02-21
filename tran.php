<?php

   $conn =mysqli_connect("localhost","root","","bms");

   $snd="";
   $rcv="";
   $amt="";
   $sts="";
   
if(isset($_POST['submit'])){
    $snd=$_POST['from'];
    $rcv=$_POST['to'];
    $amt= $_POST['amt'];
    $sts = "Transaction Successful! ";
    $sql="Select amt from tran where ac=".$snd."";
    $res = mysqli_query($conn,$sql);
    while($row =mysqli_fetch_assoc($res)){
       $chk = $row['amt'] - $amt;
     }
    if($chk>0){
    $sql = "UPDATE  tran SET amt = amt-".$amt." WHERE ac=".$snd."";
    if(mysqli_query($conn,$sql)){
        $sql = "UPDATE tran SET amt = amt+".$amt." WHERE ac=".$rcv."";
        if(mysqli_query($conn,$sql)){
            $sql = "Insert into stmt Values(".$snd.",".$rcv.",".$amt.")";
           if( mysqli_query($conn,$sql)){
                $sts = "Transaction Successful! <br> From: ".$snd." to:".$rcv." Amount: ₹".$amt;
           }
        }
        else{
            $sts = "Transaction Not Successful! ERR:001 ";
            $sql = "UPDATE tran SET amt = amt+".$amt." WHERE ac=".$snd."";
            mysqli_query($conn,$sql);
        }
    }else{
        $sts = "Transaction Not Successful! ERR:002";
    }
}else{
    $sts = $snd." have Insufficient Balance";
   }
}
$stmt = "Select * from tran";
$res = mysqli_query($conn,$stmt);
?>
<html>
   <head>
    <title>Banking Management System</title>
    <link type="text/css" rel="stylesheet" href="assest/css/app.css">
    </head>
   <body>
       
       <div class="wlc">Welcome to Online Management system</div>
       <div class="sts"><?php echo $sts;?></div>
       <div class="opt">
         <form method="post" >
          <label>Account from:</label> 
              <input type="text" placeholder="Account Number" name="from" required>
           <label>Transfer to :</label>
               <input type="text" placeholder="account nubmer" name="to" required>
           <label>Amount (₹): </label>
                <input type="number" name="amt" placeholder="Amount in ₹" required>
           <input type="submit"  name="submit" value="Transfer" class="h">
         </form>
       </div>
       <div class="output">
          <!-- by php-->
           <div class="table" align="center">
              <div class="tr">
                  <div class="td"><h1><center>User Account Info</center></h1></div>
               </div>
              <div class="tr tp">
                  <div class="th">A/C No</div>
                  <div class="th">Name</div>
                  <div class="th">Phone</div>
                  <div class="th">Amount(₹)</div>
               </div>
               <?php  
                  if(mysqli_num_rows($res)>0){
                      while($row=mysqli_fetch_assoc($res)){
                          echo " <div class='tr'>
                                    <div class='th'> ".$row['ac']."</div><div class='th'>".$row['name']."</div><div class='th'>".$row['phone']."</div><div class='th'>".$row['amt']."</div></div>";
                      }
                  }
               
               ?>
           </div>
          
       </div>
    
    </body>

</html>