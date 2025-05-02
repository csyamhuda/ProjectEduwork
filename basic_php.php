<!DOCTYPE html>
<html>
<body>
    
<?php
echo "Belajar bahasa Pemrograman PHP pertama saya!";
$nilai = "Ada nilainya";
/*if($nilai > 30)
if($nilai > 50){
    echo"nilai lebih dari 50";
}else{
    echo "nilai lebih dari 30 dan kurang dari 50";
}elseif($nilai > 20){
    echo "nilai lebih dari 20";
}else{
    echo "nilai kurang dari 20";
}
$status = $nilai > 30 ? "nilai lebih dari 30": "nilai kurang dari 30";
echo $status;*/
$status = $nilai ?? "Tidak ada nilai!";
echo $status;
?>

</body>
</html>