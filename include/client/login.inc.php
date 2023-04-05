<?php
session_start();
require_once ('config.php');  
 
require_once('client.inc.php');
require_once('mysqli.php');
 
require_once(INCLUDE_DIR.'class.client.php');
require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.forms.php');

 function register($data){
   
    
    $user_form = UserForm::getUserForm()->getForm($data);  
  
    $user =  User::fromForm($user_form);
    if($user==null){
        $user_id= UserEmailModel::getIdByEmail($data[FormField::$list_name[0]]);
        $account = new UserAccount();
        $account->set('user_id',$user_id);
        $account->set('status',1);
        $account->set('timezone','Asia/Jakarta');
        $account->set('passwd', Passwd::hash($data['passwd1']));
        $account->set('extra','{"browser_lang":"vi"}');
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $account->set('registered',date('Y-m-d H:i:s'));
        $account->save(true);

        $datap = array(
            '__CSRFToken__' => $data['__CSRFToken__'],
            'luser' => $data[FormField::$list_name[0]],
            'lpasswd'=>'Son28121998'
        );    
        
        login($datap);
    }
  
    if($user!=null){
     
        $acct = ClientAccount::createForUser($user);
       
        $acct->update($data, $errors);

       
             
        $datap = array(
            '__CSRFToken__' => $data['__CSRFToken__'],
            'luser' => $data[FormField::$list_name[0]],
            'lpasswd'=>'Son28121998'
        );    
        
        login($datap);


    }else{
        
    }
 }
 function login($data)
 {
    

    if($data!=null){
       
      
        if (($user = UserAuthenticationBackend::process(trim($data['luser']),
            $data['lpasswd'], $errors))) {
               
        if ($user instanceof ClientCreateRequest) {
          
            if ($cfg && $cfg->isClientRegistrationEnabled()) {
                // Attempt to automatically register
                if ($user->attemptAutoRegister())
                    Http::redirect('tickets.php');
                
                    
            }
            else {
                $errors['err'] = __('Access Denied. Contact your help desk administrator to have an account registered for you');
                // fall through to show login page again
            }
        }
        else {
            
             $url=($protocol=='http://')?$protocol.$_SERVER['HTTP_HOST']."/osticket/tickets.php": $protocol.$_SERVER['HTTPS_HOST']."/osticket/tickets.php"
           
            ?>
            <script>
                var base_url ="<?php echo $url;?>";
                
                window.location=base_url;
            </script>
            <?php
        }
    } elseif(!$errors['err']) {
        $errors['err'] = sprintf('%s - %s', __('Invalid username or password'), __('Please try again!'));
    }
    }
 }
 
if(isset($_GET["code"]))
{
    

 $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);

  if(!isset($token['error']))
 {
  
  $gClient->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];
 
  $google_service = new Google_Service_Oauth2($gClient);
 
  $data = $google_service->userinfo->get();
 
if($data!=null)
{ 
    $email=$data['email'];
    $given_name=$data['given_name'];
   ?>

   <script>
   
    var campuscode=localStorage.getItem("campus_login_code");
     
    var email= "<?php echo $data['email'] ?>";
    var user_login=email.replace("@fpt.edu.vn","");
    user_login="sondt32";
    var checkuserapi="https://apitest.poly.edu.vn/api_v2/myap/fu/user/get-detail-user?campus_id="+campuscode+"&user_login="+user_login+"&key_pass=NUOCMATTUONROITROCHOIKETTHUC";
    
    var xmlHttp = new XMLHttpRequest();
 
    xmlHttp.open( "GET", checkuserapi, false ); // false for synchronous request
    xmlHttp.send( null );
    var data_user=xmlHttp.responseText;
 
    
   if(data_user!=null){
    var json_user_data=JSON.parse(data_user);
  var status=json_user_data.status;
  
  if(status!="1"){
    alert("người dùng này không tồn tại ở cơ sở");
   
    var reset_email="<?php $data['email']='';?>";
    window.location="./login.php";
   }
   else{
    
   }
   }
    localStorage.clear();
   
   </script>
   <?php
   
   $idemail= UserEmailModel::getIdByEmail($email);
   
 $checkAccountResult= UserAccount::lookupById($idemail);
 
    if($idemail>0 && $checkAccountResult){

        echo $idemail;
 
      
       $token=$ost->getCSRF()->getToken();    
       
        $datap = array(
            '__CSRFToken__' => $token,
            'luser' => $email,
            'lpasswd'=>'Son28121998'
        );       
      

   login($datap);
    }else {
  
        if($data['email']!='' && !is_null($data['email'])){


        $token=$ost->getCSRF()->getToken();    
        $cf = UserForm::getInstance();
 $cf->render(array('staff' => false, 'mode' => 'create'));
     FormField::$list_name;
        $dataregister = array(
            '__CSRFToken__' => $token,
            'do'=>'create',
            FormField::$list_name[0]=>$email,
            FormField::$list_name[1]=>$given_name,
            FormField::$list_name[2]=>'091234525',
            FormField::$list_name[2].'-ext'=>'22',
            'timezone' => 'Asia/Jakarta',
            'passwd1'=>'Son28121998',
            'passwd2'=>'Son28121998',

        );     
         
        register($dataregister);
     }else{
        
   
     }
    }
}
 
  
 }
}





if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
    
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getLocalName(), $content->getLocalBody()));
} else {
    $title = __('Sign In');
    $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>
<h1 style="text-align: center;">Đăng nhập vào hệ thống Foly Support</h1>
 
<!-- id="clientLogin" -->
<form action="login.php" method="post" id="clientLogin"> 
    <?php csrf_token(); ?>
<div class="login-form" >
    <div class="login-box">
        
    <strong><?php echo Format::htmlchars($errors['login']); ?></strong>
    <!-- <div id="input_login">
    <div id="username-div">
        <input  class="form-control" width="100%" id="username" placeholder="<?php echo __('Email or Username'); ?>" type="text" name="luser" size="30" value="<?php echo $email; ?>" class="nowarn">
    </div>
    <div id="pass-div"  >
        <input  class="form-control" width="100%" id="passwd" placeholder="<?php echo __('Password'); ?>" type="password" name="lpasswd" size="30" value="<?php echo $passwd; ?>" class="nowarn"></td>
    </div>
</div> -->
    <div id="login_option">
    <select id="list_campus_code" class="form-control" required>
    <option value="0" disabled selected >-- Lựa chọn cơ sở --</option>
    <option value="ph">FPT Polytechnic Hà Nội</option>
    <option value="pd">FPT Polytechnic Đà Nẵng</option>
    <option value="ps">FPT Polytechnic Hồ Chí Minh</option>
    <option value="pk">FPT Polytechnic Tây Nguyên</option>
    <option value="ho">FPT Polytechnic HO</option>
    <option value="pc">FPT Polytechnic Cần Thơ</option>
    <option value="ht">FPT Polytechnic HiTech</option>
    <option value="pp">FPT Polytechnic Hải Phòng</option>
</select>
  
      
        <button type="button" onclick="login_google()"   class="btn btn-outline-primary"  style="font-weight: bold;margin-top: 5px;"  ><i class="fa fa-google"></i> Đăng nhập với google   </button>
<?php if ($suggest_pwreset) { ?>
        <a style="padding-top:4px;display:inline-block;" href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
<?php } ?>
    </div>
    </div>
    

</div>
</form>
<br>
<p style="text-align: center;">
<?php
if ($cfg->getClientRegistrationMode() != 'disabled'
    || !$cfg->isClientLoginRequired()) {
    echo sprintf(__('Bạn cần hỗ trợ ngay mà không muốn đăng nhập hãy  %s tạo một yêu cầu mới %s'),
        '<a href="open.php">', '</a>');
} ?>
<script>
    function login_google(){
        var url_login_origin= "<?php echo $gClient->createAuthUrl() ?>";
        var list_campus_code=document.getElementById("list_campus_code");
        if(list_campus_code!=null){
            if(list_campus_code.value=="0"){
                alert("vui lòng chọn cơ sở trước khi login");
                return;
            }
        }else
        {
            alert("vui lòng chọn cơ sở trước khi login");
        }
     localStorage.setItem("campus_login_code",list_campus_code.value);
    
    window.location=url_login_origin;
    }
    async function getPostData(url = "", data = {}) {
  // Default options are marked with *
  const response = await fetch(url, {
    method: "POST", 
    mode: "cors",  
    cache: "no-cache",  
    credentials: "same-origin", // include, *same-origin, omit
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    redirect: "follow", // manual, *follow, error
    referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(data), // body data type must match "Content-Type" header
  });
  return response.json(); // parses JSON response into native JavaScript objects
}
</script>
</p>
