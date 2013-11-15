<?php include 'api.class.php'; ?>
<body>

<?php
echo "<pre>";
print_r(SMS::getAllContacts());
echo "<br />";
//print_r(SMS::getMessages('08563246774'));
echo "<br />";
//print_r(SMS::sendMessages('08563246774','testing lewat api bro yang ke 2'));
?>

</body>