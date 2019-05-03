<?php
?>



<h3><?=$model->title?></h3>
<p><strong>Описание:</strong><?=$model->description?></p>
<?php
    if($model->filename){
    foreach ($model->filename as $onefile) {
        echo('<p><img width="200" src="/images/' . $onefile . '"> </p>');
    }
}
?>



