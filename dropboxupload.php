<?php
require_once("dropbox/DropboxClient.php");
$dropbox = new DropboxClient(array(
  'app_key' => "p90wpkf9zzg1818",
  'app_secret' => "2ftxooeu76ubpkh",
  'app_full_access' => false,
  ),'en');
handle_dropbox_auth($dropbox); // see below
  // if there is no upload, show the form
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
  $upload_name = $_FILES["the_upload"]["name"];
  $result = $dropbox->UploadFile($_FILES["the_upload"]["tmp_name"], $upload_name);
  print_r($result);
}
// store_token, load_token, delete_token are SAMPLE functions! please replace with your own!
function store_token($token, $name){
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
  die("Authentication required".$auth_url);
}
}

?>