<?php
    Controller::setSession();
    if(!isset($_SESSION['review-items'])) Controller::createView('index');
    $items = $_SESSION['review-items'];


?>
<div class='container-fluid mt-5 pt-5' style='background-color:#f3f3f3;'>
    <div class='container'>
        <dl class='row'>
            <dt class='col-3'>Region</dt>
            <dd class='col-9'><?php echo $items['region']?></dd>
            
            <dt class='col-3'>Items</dt>
            <dd class='col-9'><?php echo $items['items']?></dd>
            
            <dt class='col-3'>Duration</dt>
            <dd class='col-9'><?php echo $items['duration']?></dd>
            
            <dt class='col-3'>Score</dt>
            <dd class='col-9'><?php echo $items['total_score']?></dd>
            
            <dt class='col-3'>Date Finished</dt>
            <dd class='col-9'><?php echo $items['date_finished']?></dd>
            
            <hr class='my-4'>
            <?php
                foreach($items['data'] as $item){
                    echo "
                    <dt class='col-3'>Question</dt>
                    <dd class='col-9'>".$item['question']."</dd>
                    
                    <dt class='col-3'>Your Answer</dt>
                    <dd class='col-9'>".$item['answer']."</dd>
                    
                    <dt class='col-3'>Correct Answer</dt>
                    <dd class='col-9'>".$item['answer_correct']."</dd>
                    
                    <dt class='col-3'>Explanation</dt>
                    <dd class='col-9'>".$item['explanation']."</dd>
                    <hr class='my4'>
                    ";
                }
            ?>
        </dl>
    </div>
</div>