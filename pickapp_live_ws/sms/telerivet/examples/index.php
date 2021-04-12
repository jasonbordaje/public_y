<?php

require_once '../telerivet.php';

$YOUR_API_KEY = 'Wlaea_Dk8St7rzqBjqcaItACIg5TbLTSGIEy';
$project_id = 'PJ4dd2e4557716eaa8';

$tr = new Telerivet_API($YOUR_API_KEY);
$project = $tr->initProjectById($project_id);

$sent_msg = $project->sendMessage(array(
    'content' => "hello world", 
    'to_number' => "+639302999876"
));