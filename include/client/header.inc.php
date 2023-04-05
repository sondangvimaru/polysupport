<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes().";");

if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}

// Dropped IE Support Warning
if (osTicket::is_ie())
    $ost->setWarning(__('osTicket no longer supports Internet Explorer.'));
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?8fbc7ee" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/toast.min.css" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?8fbc7ee" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?8fbc7ee"
         media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.13.1.custom.min.css?8fbc7ee"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/jquery-ui-timepicker-addon.css?8fbc7ee" media="all"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?8fbc7ee" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?8fbc7ee" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?8fbc7ee"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?8fbc7ee"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?8fbc7ee"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?8fbc7ee"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/metro/metro-components.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/metro/metro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <style >
        label#select_label label {
    width: 98%;
}
        div#msg_notice {
    height: 30px;
    }
div#msg_error {
    height: 30px;
}
        div#thankyoupage {
    font-family: cursive;
    font-size: medium;
    font-style: oblique;
    font-weight: 500;
}
        a.button.primary {
    padding-top: 3%;
}
a.button.success {
    padding-top: 3%;
}
.redactor-box.redactor-blur.redactor-styles-on.redactor-toolbar-on {
    width: 98%;
}
.dropzone {
    width: 98%;
}
        div#tilte_div {
    text-align: center;
}
        @import "compass/css3";
 *, *:before, *:after {
	 box-sizing: border-box;
	 margin: 0;
	 padding: 0;
}
 @font-face {
	 font-family: pfs-bold;
	 src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/PFSquareSansPro-Bold.otf');
}
 body {
	 background: #35414a;
}
 .list_campus_code{
    appearance: none;
	 border: 0;
	 outline: 0;
	 font: inherit;
	/* Personalize */
	 width: 20em;
	 height: 3em;
	 padding: 0 4em 0 1em;
	 background: url(https://upload.wikimedia.org/wikipedia/commons/9/9d/Caret_down_font_awesome_whitevariation.svg) no-repeat right 0.8em center / 1.4em, linear-gradient(to left, rgba(255, 255, 255, 0.3) 3em, rgba(255, 255, 255, 0.2) 3em);
	 color: white;
	 border-radius: 0.25em;
	 box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.2);
	 cursor: pointer;
 }
 .list_campus_code option {
	 color: inherit;
	 background-color: #320a28;
     
}
.form-control option{
    text-align: center;
}
 .list_campus_code:focus {
	 outline: none;
}
 .list_campus_code::-ms-expand {
	 display: none;
}
        .login-box {
    display: contents;
}
  body {
  background: #daf1d2;
}
div#login_option {
    display: grid;
}
div#username-div {
    display: grid;
}
div#pass-div {
    display: grid;
}
button.btn.btn-primary {
    width: 100%;
    height: auto;
    margin-top: 5px;
}
#clientLogin {
    display: block;
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
  background: #ffff;
}
#footer #poweredBy {
    display: block;
    width: 200px;
    height: 50px;
    outline: none;
    text-indent: -9999px;
    margin: 0 auto;
    background: url("assets/default/images/fpolylogo.png") top center no-repeat;
    
    background-size: auto 50px;
}

div#container {
    background: aliceblue;
}
#mobiuser{
display:none;
}
       @media (max-width: 900px){
        label#select_label {
    width: 98%;
}
        .select-container {
   width: fit-content;
  }

  .select-container select {
    font-size: inherit;
  }
        
        #clientLogin {
    height: auto!important;
}
        button.btn.btn-primary {
            margin-top: 5px;
             width: auto;
             height: auto;
}
        #pcUser{
            display: none;
        }
        #mobiuser{
       
        display: inline-flex;
            }
            .dropdown-menu.show {
    width: auto;
}
        #footer{
            width: 100%;
            overflow:hidden;
        }
        .option_login {
          margin-top: 60px;
        }
        form#clientLogin {
        width: 96%;
        background-position: 50% 60%;
        height: 440px;

        }
        h1#h1info {
          text-align: center;
         margin: 0px;
    }
        div#ticketThread {
        width: 85%;
        padding-left: 5%;
        padding-right: 5%;
        }
       
        .pull-right {
            float: right;
             margin: 0 0 0 0;
         padding: 0 0 0 0;
}
        .login-box {
          display: block;
          box-shadow: none;
          padding-bottom: 40px;
          margin-bottom: 10px;
        }
        .option_login{
           padding-top: 20px;
        }
        .login-box p {
        text-align: -webkit-center;
        }
          h1{
            text-align:center;
        }
        p {
        text-align: center;
    }
    li.form-control a {
    display: table-cell !important;
    font-size:x-large ;
    
    
}
    .input {
    display: inherit;
}
    a.button.primary {
    padding-top: 2%;
}
a.button.success {
    padding-top:2%;
}
    .dropzone {
    width: 100% !important;
}
    .redactor-styles.no-pjax.redactor-in.redactor-in-0 p {
    text-align: justify !important;
}
    .instructions {
    position: absolute;
    margin-top: 20px;
      
    display: inline-grid;
    text-align: -webkit-center;
    padding-right: 35px;
}
    }
        
    tr {
    width: 100%;
    display: inline-table;
}

#new_ticket_table{
    width: 99%;
}
label.title_survey  {
    width: 100%;
}
label.title_survey input {
    width: 100%;
}
 
    </style>
   
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-16x16.png" sizes="16x16" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.5.1.min.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.13.1.custom.min.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-timepicker-addon.js?8fbc7ee"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?8fbc7ee"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?8fbc7ee"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?8fbc7ee"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
    <script src="https://cdn.korzh.com/metroui/v4.5.1/js/metro.min.js"></script>
    <script>
        function myFunction() {
  var x = document.getElementById("nav");
  if (x.className === "flush-left") {
    x.className += " responsive";
  } else {
    x.className = "flush-left";
  }
}

    </script>

    
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . htmlspecialchars($_SERVER['REQUEST_URI']); ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
<?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . htmlspecialchars($_SERVER['REQUEST_URI']); ?>"
            hreflang="x-default" />
<?php
    }
    ?>
</head>
<body>
    <div id="container">
        <?php
        if($ost->getError())
            echo sprintf('<div class="error_bar">%s</div>', $ost->getError());
        elseif($ost->getWarning())
            echo sprintf('<div class="warning_bar">%s</div>', $ost->getWarning());
        elseif($ost->getNotice())
            echo sprintf('<div class="notice_bar">%s</div>', $ost->getNotice());
        ?>
        <div id="header">
   
           <div id="pcUser">
           <div class="pull-right flush-right">
            <p>
           
            
             
           <a> <?php
                if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                    && !$thisclient->isGuest()) {
                 echo Format::htmlchars($thisclient->getName()).'&nbsp;|';
                 ?></a>
                <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> |
               <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a>  -
              <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
            <?php
            } elseif($nav) {
                if ($cfg->getClientRegistrationMode() == 'public') { ?>
                    <?php echo __('Guest User'); ?> | <?php
                }
                if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                    <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a><?php
                }
                elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                    <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
<?php
                }
            } ?>

         </div>
           </div>
           <div id="mobiuser">
           <div class="pull-right flush-right">
            <p>
            <div class="dropdown show">
             <a
             class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-user-circle" aria-hidden="true"></i></a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
           <a> <?php
                if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                    && !$thisclient->isGuest()) {
                 echo Format::htmlchars($thisclient->getName()).'&nbsp;';
                 ?></a>
                <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> 
               <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a>  -
              <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
            <?php
            } elseif($nav) {
                if ($cfg->getClientRegistrationMode() == 'public') { ?>
                    <?php echo __('Guest User'); ?>  <?php
                }
                if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                    <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a><?php
                }
                elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                    <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
<?php
                }
            } ?>

        </div>
           </div>
        </div>
            </p>

            <p>
<?php
if (($all_langs = Internationalization::getConfiguredSystemLanguages())
    && (count($all_langs) > 1)
) {
    $qs = array();
    parse_str($_SERVER['QUERY_STRING'], $qs);
    foreach ($all_langs as $code=>$info) {
        list($lang, $locale) = explode('_', $code);
        $qs['lang'] = $code;
?>
        <a   class="flag flag-<?php echo strtolower($info['flag'] ?: $locale ?: $lang); ?>"
            href="?<?php echo http_build_query($qs);
            ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>">&nbsp;</a>
<?php }
} ?>
            </p>
            </div>
            <a class="pull-left" id="logo" href="<?php echo ROOT_PATH; ?>index.php"
            title="<?php echo __('Fpoly Support'); ?>">
                <span class="valign-helper"></span>
                <img src="<?php echo ROOT_PATH; ?>logo.php" border=0 alt="<?php
                echo $ost->getConfig()->getTitle(); ?>">
            </a>
        </div>
        <div class="clear"></div>
        <?php
        if($nav){ ?>
        <nav class="navbar navbar-expand-lg navbar-light "style="background-color: #e3f2fd;">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
     
      <?php
            if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                 
                foreach($navs as $name =>$nav) {
                    
                    echo sprintf('<li><a class="%s %s" href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                }
            } ?>
    </ul>
    
  </div>
 
</nav>

        <?php
        }else{ ?>
         <hr>
        <?php
        } ?>
        <div id="content">

         <?php if($errors['err']) {
            
          
            ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
         <?php } ?>
         
