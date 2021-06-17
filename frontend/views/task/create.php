<?php

/** @var \yii\web\View $this */
/** @var \frontend\models\forms\TaskForm $model */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Публикация нового задания";
?>


<section class="create__task">
    <?= Html::tag('h1', $this->title); ?>
    <?php Pjax::begin([
        // 'id' => 'ajax-create-task',
        'options' => ['class' => 'create__task-main']
    ]); ?>
    <?= $this->render('_createForm', ['model' => $model]); ?>
    <?php Pjax::end(); ?>

    <?php if (isset($this->blocks['task-form-submit-button'])) : ?>
        <?= $this->blocks['task-form-submit-button'] ?>
    <?php endif; ?>
</section>


<?php

// $this->registerJs('
//         console.log("Ready to Pjax");

//         $(document).on("pjax:send", function() {
//             $("#new-form").text("Pjax send");
//         });

// 		$("#ajax-create-task")
//         .on("pjax:complete", function() {
//             console.log("Pjax Complete");
//         })
//         .on("pjax:end", function() {
//             console.log("Success");
// 			$.pjax.reload({container:"#new-form"});
// 		});
// ');
