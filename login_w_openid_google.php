<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'lightopenid/openid.php';
try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('maydenlab.slu.edu');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array(
  				'namePerson/first',
  				'namePerson/last',
  				'contact/email',
			);
            header('Location: ' . $openid->authUrl());
        }
?>
        <form action="?login" method="post">
          <table>
            <tr>
              <td colspan=2>
                <h3>Login with OpenID (Google)</h3>
                <p class="text">To link your Cypriniformes Commons account with an OpenID (Google), enter it here and click Login with OpenID</p>
              </td>
            </tr>           
            <tr>
              <td colspan=2><button type="submit">Login with OpenID (Google)</button></td>
            </tr>           
          </table>
        </form>
        <br><br> 
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        //echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
		if( $openid->validate() ){
        	$data = $openid->getAttributes();
        	$email = $data['contact/email'];
        	$first = $data['namePerson/first'];
			//echo "Identity : $openid->identity <br>";
        	//echo "Email : $email <br>";
        	//echo "First name : $first";
			

			header('Location: login2_w_openid_google.php?gmail='.$email.'');
			//header('Content-Disposition: attachment; filename="'.$name.'"');
		}
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>