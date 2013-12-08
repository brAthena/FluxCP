<?php
/* Contact Form Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.01
 */
 
if (!defined('FLUX_ROOT')) exit;
$emailTitle = sprintf('Contact Form Submission');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo htmlspecialchars($emailTitle) ?></title>
		<style type="text/css" media="screen">
			body, table {
				font-family: sans-serif;
				font-size: 10pt;
			}
		</style>
	</head>
	<body>
		<h2><?php echo htmlspecialchars($emailTitle) ?></h2>
		
		<p>Um membro enviou uma pergunta/consulta.</p>
		
		<p>
			<table style="margin-left: 18px">
				<tr>
					<td align="right">ID da conta:&nbsp;&nbsp;</td>
					<th align="left">{ID da conta}</th>
				</tr>
				<tr>
					<td align="right">Nome:&nbsp;&nbsp;</td>
					<th align="left">{Nome}</th>
				</tr>
				<tr>
					<td align="right">Email:&nbsp;&nbsp;</td>
					<th align="left">{Email}</th>
				</tr>
				<tr>
					<td align="right">Assunto:&nbsp;&nbsp;</td>
					<th align="left">{Assunto}</th>
				</tr>
				<tr>
					<td align="right">Texto:&nbsp;&nbsp;</td>
					<th align="left">{Texto}</th>
				</tr>
				<tr>
					<td align="right">IP:&nbsp;&nbsp;</td>
					<th align="left">{IP}</th>
				</tr>
			</table>
		</p>
		<br />
		<p><em><strong>Nota:</strong> Este é um e-mail automatizado, por favor não responda para este endereço.</em></p>
	</body>
</html>