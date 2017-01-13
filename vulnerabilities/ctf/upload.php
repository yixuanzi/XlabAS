<?php
	if (isset($_POST['Upload'])) {

			$target_path = DVWA_WEB_PAGE_TO_ROOT."hackable/uploads/";
			$target_path = $target_path . basename($_FILES['uploaded']['name']);
			$uploaded_name = $_FILES['uploaded']['name'];
			$uploaded_type = $_FILES['uploaded']['type'];
			$uploaded_size = $_FILES['uploaded']['size'];
			$types=array("image/png","image/jpeg","image/gif","image/jpg");
		
			$ext=strtolower(substr($uploaded_name,-3));
			if (in_array($uploaded_type,$types) && ($uploaded_size < 100000)){

				if(!move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {
				
					$html .= '<pre>';
					$html .= 'Your image was not uploaded.';
					$html .= '</pre>';
					
      			} else {
				
					$html .= '<pre>';
					
					if($ext=='php'){
						require_once '../../hackable/ctf/ctf.php';
						$html .=$FLAG['upload'];
					}else{
						$html .= $target_path . ' succesfully uploaded!<br>';
					}
					$html .= '</pre>';
					
					}
			}
			else{
				echo '<pre>Your image was not uploaded.</pre>';
			}
		}
		
$page = dvwaPageNewGrab();
$page[ 'title' ] .= $page[ 'title_separator' ].'CTF 8';
$page[ 'page_id' ] = 'ctf';

$page[ 'help_button' ] = 'upload';
$page[ 'source_button' ] = 'upload';

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>被欺骗的代码</h1>

	<div class=\"vulnerable_code_area\">

		<form enctype=\"multipart/form-data\" action=\"#\" method=\"POST\" />
			<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\" />
			Choose an image to upload:
			<br />
			<input name=\"uploaded\" type=\"file\" /><br />
			<br />
			<input type=\"submit\" name=\"Upload\" value=\"Upload\" />
		</form>

		{$html}

	</div>
</div>
";

?>