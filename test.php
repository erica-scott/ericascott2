<form method="post" action="">
   <input type="text" name="number">
   <input type="submit" name="submit" value="Run">
</form>
<?php
if (isset($_POST['submit'])) {
   $number = $_POST['number'];
   print "Your original number is: " . $number."<br/>";
   while ($number != 1) {
      for ($i = 0; $i < strlen($number); $i++) {
         if ($i == 0) {
            $temp = pow($number[$i], 2);
         } else {
            $temp += pow($number[$i], 2);
         }
      }
      $number = (string)$temp;
      print $number."<br/>";
   }
   print "This is a happy number!";
}
?>