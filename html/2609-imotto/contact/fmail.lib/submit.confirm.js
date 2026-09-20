<!--
//標準ボタン利用時
//document.write('<input type="button" id="submit_confirm" value="入力内容を確認する" class="default_button" onclick="fmail_sending(this.form)" onkeypress="fmail_sending(this.form)" />');
//画像ボタン利用時
document.write('<input type="button" id="submit_confirm" class="submit_confirm_button" value="入力内容を確認する" title="入力内容を確認する" onclick="fmail_sending(this.form)" onkeypress="fmail_sending(this.form)" />');
//モバイルで邪魔にならないようperl側で処理
//document.write('<div id="mailfrom_hidden_object"><input type="submit" /></div>');
//-->