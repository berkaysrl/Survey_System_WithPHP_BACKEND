<?php require_once ("baglan.php"); ?>
<!doctype html>
<html lang="tr-TR">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Font awesome internetten alınma-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Anket Uygulaması</title>
</head>
<body>
    <?php
        require_once("header.php");
        $soru_cek=$db->prepare("SELECT * FROM `sorular` ORDER BY `sorular`.`ID` ASC");
        $soru_cek->execute();
        $Sorular=$soru_cek->fetchAll(PDO::FETCH_ASSOC);
        $sorular_count=$soru_cek->rowCount();
    ?>
<div class="row">
    <div class="col md-4">
    </div>
    <div class="col md-4 mt-4">
                <center><h1>Sorular</h1></center>
                <form method="post">
                <?php
                    if($sorular_count>0)
                    {
                        $soru_numarasi=0;
                        foreach($Sorular as $soru)
                        {
                            $soru_numarasi++;
                        ?>
        <div class="card">
                            <div class="card-header">
                                <?php echo $soru_numarasi." - ".$soru['Soru']?>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-2">
                                        <input type="hidden" value="<?php echo $soru['ID'];?>" name="soru_id[]  ">
                                        <input type="radio" value="Mukemmel" name="<?php echo "soru[]".$soru_numarasi;?>"><i class="fa-solid fa-face-smile-beam" style="color:#FFD700"></i>
                                        <input type="radio" value="Normal" name="<?php echo "soru[]".$soru_numarasi;?>"><i class="fa-solid fa-face-rolling-eyes"></i>
                                        <input type="radio" value="Kotu" name="<?php echo "soru[]".$soru_numarasi;?>"><i class="fa-solid fa-face-sad-cry" style="color:red"></i>
                                </blockquote>
                            </div>
        </div>
                <?php }//foreach kapatma
                        }//if kapatma
                        else
                {
                    echo "<div class='alert alert-danger'>Görüntülenecek Soru Bulunamadı</div>";
                }?>
        <div class="d-grid gap-2 mt-2">
            <input class="btn btn-success" type="submit" name="gonder"></inputbutton>
        </div>
                </form>
            <?php
            if(isset($_POST['gonder'])) {
                $kontrol=false;
                if(isset($_POST['soru']))
                {
                    $Gelen_cevaplar=$_POST['soru'];
                    $Soru_id=$_POST['soru_id'];
                    $Cevaplar=array();
                    for($i=0;$i<$soru_numarasi;$i++)
                        {
                            if(empty($Gelen_cevaplar[$i]))
                            {
                                $kontrol=false;
                                break;
                            }
                            else
                            {
                                $kontrol=true;
                            }
                        }
                    echo "<pre>";
                    if($kontrol==true)
                    {
                        $Cevaplar=array_combine($Soru_id,$Gelen_cevaplar);
                        foreach($Cevaplar as $soru_id=>$cvp)
                            {
                                $CevapKaydet =$db->prepare("INSERT INTO cevaplar(soru_id,cevaplar) values(:soru_,:cvp_)");
                                $CevapKaydet->execute(array(
                                        "soru_"=>$soru_id,
                                        "cvp_"=>$cvp
                                )
                                );
                            }
                        if($CevapKaydet)
                        {
                            echo "Anketi başarıyla tamamladınız!";

                        }
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'>Anketi tam doldurunuz</div>";

                    }
                }
            }
                ?>
    </div>
    <div class="col md-4">
    </div>


</div>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>