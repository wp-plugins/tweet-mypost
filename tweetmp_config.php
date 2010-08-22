<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Configuração Tweet myPost</h2>
<?php
if (isset($_POST['submit'])) {
	update_option('tweetmp_consumerkey', trim($_POST['set_ckey']));
	update_option('tweetmp_consumersecret', trim($_POST['set_csec']));
	update_option('tweetmp_token', trim($_POST['set_token']));
	update_option('tweetmp_secret', trim($_POST['set_secret']));
?>
    <div class="updated">
    	<p><strong>Configurado com Sucesso.</strong></p>
    </div>
    <?php
}
?>
<form method="post">
<table border="0" cellpadding="5" cellspacing="10" width="100%">
<tr>
<td valign="top" width="50%">
<div id="poststuff">
<div class="postbox">
<h3 class="hndle">OAuth Twitter Config.</h3>
<div class="inside">
<p>
<p>Consumer Key:<br>
<input type="text" name="set_ckey" size="60" value="<?php echo get_option('tweetmp_consumerkey'); ?>" style="background: #FAFAD2;"/></p>
<br/>
<p>Consumer Secret: <br>
<input type="text" name="set_csec" size="60" value="<?php echo get_option('tweetmp_consumersecret'); ?>" style="background: #FAFAD2;"/></p>
<br/>
<p>Access Token:<br>
<input type="text" name="set_token" size="60" value="<?php echo get_option('tweetmp_token'); ?>" style="background: #FAFAD2;"/></p>
<br/>
<p>Access Token Secret: <br>
<input type="text" name="set_secret" size="60" value="<?php echo get_option('tweetmp_secret'); ?>" style="background: #FAFAD2;"/></p>
<small><em></em></small>
</p>
</div>
</div>
</div>
</td>
<td valign="top" width="50%">
<div id="poststuff">
<div class="postbox">
<h3 class="hndle">Suporte</h3>
<div class="inside">
<p>Já tem sua Access Token?<br/>
Registre sua <a href="http://dev.twitter.com/apps/new" target="_blank">Aplicação no Twitter</a>.</p>
<p>
<small>*<em>Passo-a-passo, acesse: <a href="http://www.reitor.org/wp-plugins/tweet-mypost/" target="_blank">www.reitor.org/wp-plugins/tweet-mypost/</a></em></small>
</p>
</div>
</div>
</div>
<div id="poststuff">
<div class="postbox">
<h3 class="hndle">Ajude</h3>
<div class="inside">
<p>Ajude-me a continuar, faça uma doação.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="FPNFQ6GEZN43W">
<input type="image" src="https://www.paypal.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais fácil e segura de efetuar pagamentos on-line!">
<img alt="" border="0" src="https://www.paypal.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
</div>
</div>
</div>
</td>
</tr>
<div align="right">
<input type="submit" name="submit" class="button-primary" value="Salvar alterações" />
</form>
</div>
</table>
</div>