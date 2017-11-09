<?php
require_once('header.php');
$congvan = new CongVan();$emailaccount = new EmailAccount();
$donvisoanthao = new DonViSoanThao();
require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

$id_congvan = isset($_POST['id_congvan']) ? $_POST['id_congvan'] : '';
$kinhgui = isset($_POST['kinhgui']) ? $_POST['kinhgui'] : '';
$id_emailaccount = isset($_POST['id_emailaccount']) ? $_POST['id_emailaccount'] : '';
$arr_emaillist = array();
$congvan->id = $id_congvan; $cv = $congvan->get_one();
if(isset($cv['id_donvisoanthao']) && $cv['id_donvisoanthao']){
	$donvisoanthao->id = $cv['id_donvisoanthao']; $dvst = $donvisoanthao->get_one();
	$tendonvisoanthao = $dvst['ten'];
} else {
	$tendonvisoanthao = '';
}
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
//$mail->Host = 'mail.agu.edu.vn';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;
$mail->Username = 'trungminhphan@gmail.com';                 // SMTP username
$mail->Password = 'esqrfmrotkxvgzyn';                           // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                         // TCP port to connect to
$mail->CharSet = 'UTF-8';
//$mail->setFrom('legomarketingteam@gmail.com', 'P. Hành chính');
$mail->setFrom('trungminhphan@gmail.com', 'BQLDAĐTXD tỉnh An Giang');
echo '<a href="chitietcongvan.php?id='.$id_congvan.'" class="button primary"><span class="mif-keyboard-return"></span> Trở về</a>';
echo '<hr />';
if($id_emailaccount){
	foreach ($id_emailaccount as $k => $v) {
		if(!$congvan->check_emaillist($v)){
			$emailaccount->id = $v; $e = $emailaccount->get_one();
			$congvan->emaillist = array('id_emailaccount' => new MongoId($v), 'view'=> 0);
			$congvan->push_emaillist();
			$mail->addAddress($e['emailaddress'], $e['ghichu']);    // Add a recipient
			//$mail->addAddress('ellen@example.com');               // Name is optional
			//$mail->addReplyTo('pmtrung@agu.edu.vn', 'Phan Minh Trung');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');
			if($cv['dinhkem'] && count($cv['dinhkem']) > 0 ){
				$link_file = '<a href="http://docs.agu.edu.vn/bqlda/view.php?'.md5('id').'='.$id_congvan.'&'.md5('id_email').'='.$v.'">Chi tiết vui lòng xem tại đây</a>';
				$mail->addAttachment($target_files . $cv['dinhkem'][0]['alias_name']);
				//$link_file = 'Chi tiết vui lòng xem <a href="http://localhost/congvan/view.php?'.md5('id').'='.$id_congvan.'&'.md5('id_email').'='.$v.'">tại đây</a>';
			} else {
				$link_file = '';
			}
			$content_mail = '
				<table border="1" style="border-collapse:collapse;" cellpadding="10">
					<tr>
						<td><b>Kính gửi: </b></td>
						<td>'.nl2br($kinhgui).'</td>
					</tr>
					<tr>
						<td><b>Công văn của: </b></td>
						<td>'.$tendonvisoanthao.'</td>
					</tr>
					<tr>
						<td><b>Số công văn: </b></td>
						<td>'.$cv['socongvan'].'</td>
					</tr>
					<tr>
						<td><b>Ngày ký: </b></td>
						<td>'.($cv['ngayky'] ? date("d/m/Y",$cv['ngayky']->sec) : '').'</td>
					</tr>
					<tr>
						<td><b>Về việc: </b></td>
						<td>'.$cv['trichyeu'].'</td>
					</tr>
					<tr>
						<td><b>Ghi chú: </b></td>
						<td><b>'.$link_file.' hoặc xem đính kèm</b></td>
					</tr>
				</table>
				<hr />
				<b>BAN QUẢN LÝ ĐẦU TƯ XÂY DỰNG TỈNH AN GIANG</b> <br />
			';
$content_mail_alt = 'Kính gửi: '.$kinhgui.'

Công văn của: '.$tendonvisoanthao.'

Số công văn: '.$cv['socongvan'].'

Ngày ký: '.($cv['ngayky'] ? date("d/m/Y",$cv['ngayky']->sec) : '').'

Về việc: '.$cv['trichyeu'].'

Link xem công văn:

http://docs.agu.edu.vn/bqlda/view.php?'.md5('id').'='.$id_congvan.'&'.md5('id_email').'='.$v.'

------------------------------------------------------------------------------------------------------------
BAN QUẢN LÝ ĐẦU TƯ XÂY DỰNG TỈNH AN GIANG';
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $cv['trichyeu'];
			$mail->Body    = $content_mail;
			$mail->AltBody = $content_mail_alt;
			if(!$mail->send()) {
			    echo 'Lỗi xảy ra:';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo '<h3><span class="mif-user-check fg-blue"></span> Đã gởi email thành công</h3>';
			}
			$mail->ClearAddresses();
		}
	}

}
require_once('footer.php');
?>
