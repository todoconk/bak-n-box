<?php
require_once dirname(__FILE__). "/dropbox/DropboxClient.php";
$dropbox = new DropboxClient(
  array(
    'app_key' => DROPBOX_APP_KEY,
    'app_secret' => DROPBOX_APP_SECRET,
    'app_full_access' => false,
    ),'en');
handle_dropbox_auth($dropbox); // see below

/*
if(empty($_FILES['the_upload'])) {
  ?>
  <form enctype="multipart/form-data" method="POST" action="">
    <p>
      <label for="file">Upload File</label>
      <input type="file" name="the_upload" />
  </p>
  <p><input type="submit" name="submit-btn" value="Upload!"></p>
</form>
<?php
}else{
  $result = upload_dropbox($dropbox, $_FILES["the_upload"]["tmp_name"], $_FILES["the_upload"]["name"]);
  print_r($result);
}
*/

function upload_dropbox($dropbox, $file, $upload_name){
  return $result = $dropbox->UploadFile($file, $upload_name);
}

function store_token($token, $name){
  // store_token, load_token, delete_token are SAMPLE functions! please replace with your own!
  file_put_contents("dropbox/tokens/$name.token", serialize($token));
}

function load_token($name){
  if(!file_exists("dropbox/tokens/$name.token")) return null;
  return @unserialize(@file_get_contents("dropbox/tokens/$name.token"));
}

function delete_token($name){
  @unlink("dropbox/tokens/$name.token");
}

function handle_dropbox_auth($dropbox){
  // first try to load existing access token
  $access_token = load_token("access");
  if(!empty($access_token)) {
    $dropbox->SetAccessToken($access_token);
  }
  elseif(!empty($_GET['auth_callback'])) // are we coming from dropbox's oauth page?
  {
    // then load our previosly created request token
    $request_token = load_token($_GET['oauth_token']);
    if(empty($request_token)) die('Request token not found!');
    // get & store access token, the request token is not needed anymore
    $access_token = $dropbox->GetAccessToken($request_token);
    store_token($access_token, "access");
    delete_token($_GET['oauth_token']);
  }
    // checks if access token is required
  if(!$dropbox->IsAuthorized()){
    $return_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?auth_callback=1";
    $auth_url = $dropbox->BuildAuthorizeUrl($return_url);
    $request_token = $dropbox->GetRequestToken();
    store_token($request_token, $request_token['t']);
    die("Authentication required: ".$auth_url);
  }
}

?>