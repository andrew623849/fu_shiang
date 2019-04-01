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
                <th width="65px">交件日</td>
                <th width="75px">病人姓名</td>
                <th width="120px">齒位</td>
                <th width="45px">齒色</td>
                <th width="105px">材料</td>
                <th width="55px">費用</td>
                <th>備註</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($model as $key=>$val){
                $material_val = $material[$val['material_id']-1];
            ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $val['end_time'] ?></td>
                <td><?= $val['name'] ?></td>
                <td><?= $val['tooth'] ?></td>
                <td><?= $val['tooth_color'] ?></td>
                <td><?= $material_val['material'] ?></td>
                <td><?= $val['price'] ?></td>
                <td><?= $val['remark'] ?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>

</div>
