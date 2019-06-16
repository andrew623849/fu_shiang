<?php
use yii\helpers\Html;
use Mpdf\Mpdf;

$price = 0;
foreach($model as $key=>$val){
    $price = $val['price'] + $price;
}
?>

<div class="pdf-dealer container">
    <h1 style="text-align:center;">估價單</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>結款日期</th>
                <th>應收款金額</th>
                <th width="300px">收款金額</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= date('Y-m-d')?></td>
                <td><?= $price ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h2 style="text-align:center;">項目明細</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5px">#</td>
                <th width="65px">收件日</td>
                <th width="75px">病人姓名</td>
                <th width="80px">齒位</td>
                <th width="83px">齒色</td>
                <th width="150px">材料</td>
                <th width="55px">費用</td>
                <th width="100px">備註</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($model as $key=>$val){
                $material_val = $material[$val['material_id']];
                $td_colspan = "";
                if($val['material_id_2'] != 0){
                    $td_colspan = 'rowspan="3"';
                }elseif($val['material_id_1'] != 0){
                    $td_colspan = 'rowspan="2"';
                }
            ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $val['start_time'] ?></td>
                <td><?= $val['name'] ?></td>
                <td><?= $val['tooth'] ?></td>
                <td><?= $val['tooth_color'] ?></td>
                <td><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
                <td><?= price_mm($val['tooth'],$val['material_id']) ?></td>
                <td <?= $td_colspan ?>><?= $val['remark'] ?></td>
            </tr>
            <?php if($val['material_id_1'] != 0){
                    $material_val = $material[$val['material_id_1']];
                ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $val['tooth_1'] ?></td>
                <td><?= $val['tooth_color_1'] ?></td>
                <td><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
                <td><?= price_mm($val['tooth_1'],$val['material_id_1']) ?></td>
            </tr>
        <?php
            }
        ?>
            <?php if($val['material_id_2'] != 0){
                    $material_val = $material[$val['material_id_2']];
                ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $val['tooth_1'] ?></td>
                <td><?= $val['tooth_color_1'] ?></td>
                <td><?= $material_val['material'].'($'.$material_val['price'].')' ?></td>
                <td><?= price_mm($val['tooth_2'],$val['material_id_2']) ?></td>
            </tr>
        <?php
            }
        }?>
        </tbody>
    </table>

</div>
