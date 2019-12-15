<?php
use yii\helpers\Html;
use Mpdf\Mpdf;
use kartik\mpdf\Pdf;


$price = 0;
foreach($model as $key=>$val){
    
    $price = $val['price'] + $price;
}
$material = \app\models\MaterialSearch::ShowData('all','','material');

?>

<div class="pdf-dealer container">
    <h1 style="text-align:center;">估價單</h1>
    <table class="table table-bordered border-dark">
        <thead>
            <tr>
                <th style="border-color:black;">結款日期</th>
                <th style="border-color:black;">應收款金額</th>
                <th width="300px" style="border-color:black;">收款金額</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border-color:black;"><?= date('Y-m-d')?></td>
                <td style="border-color:black;"><?= $price ?></td>
                <td style="border-color:black;"></td>
            </tr>
        </tbody>
    </table>
    <h2 style="text-align:center;">項目明細</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="border-color:black;" width="5px">#</td>
                <th style="border-color:black;" width="65px">收件日</td>
                <th style="border-color:black;" width="75px">病人姓名</td>
                <th style="border-color:black;" width="80px">齒位</td>
                <th style="border-color:black;" width="83px">齒色</td>
                <th style="border-color:black;" width="150px">材料</td>
                <th style="border-color:black;" width="55px">費用</td>
                <th style="border-color:black;" width="100px">備註</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $fkey = 0;
            $fpay = 0;
            foreach($model as $key=>$val){
                $fpay = $val['price'] + $fpay;
                $material_val = $material[$val['material_id']];
                $td_colspan = "";
                if($val['material_id_2'] != 0){
                    $td_colspan = 'rowspan="3"';
                }elseif($val['material_id_1'] != 0){
                    $td_colspan = 'rowspan="2"';
                }
            ?>
            <tr>
                <td style="border-color:black;"><?= $key+1 ?></td>
                <td style="border-color:black;"><?= $val['start_time'] ?></td>
                <td style="border-color:black;"><?= $val['name'] ?></td>
                <td style="border-color:black;"><?= $val['tooth'] ?></td>
                <td style="border-color:black;"><?= $val['tooth_color'] ?></td>
                <td style="border-color:black;"><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
                <td style="border-color:black;" <?= $td_colspan ?>><?= $val['price'] ?></td>
                <td style="border-color:black;" <?= $td_colspan ?>><?= $val['remark']?></td>
            </tr>
            <?php if($val['material_id_1'] != 0){
                    $material_val = $material[$val['material_id_1']];
                ?>
            <tr>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"><?= $val['tooth_1'] ?></td>
                <td style="border-color:black;"><?= $val['tooth_color_1'] ?></td>
                <td style="border-color:black;"><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
            </tr>
        <?php
            }
        ?>
            <?php if($val['material_id_2'] != 0){
                    $material_val = $material[$val['material_id_2']];
                ?>
            <tr>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"></td>
                <td style="border-color:black;"><?= $val['tooth_1'] ?></td>
                <td style="border-color:black;"><?= $val['tooth_color_1'] ?></td>
                <td style="border-color:black;"><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
            </tr>
        <?php
            }
            if((($key+1) % 15 == 0 || $key == (count($model)-1)) && $key != 0){
       ?>
            <tr>
                <td style="border-color:black;text-align: right;background-color: #D3D3D3;" colspan="7" ><?= '第'.($fkey + 1).'筆 - 第'.($key+1) ?>筆的金額:</td>
                <td style="border-color:black;background-color: #D3D3D3;"><?= $fpay ?></td>
            </tr>
       <?php 
                $fpay = 0;
                $fkey = ($key+1);
            }
        }?>
        </tbody>
    </table>

</div>
