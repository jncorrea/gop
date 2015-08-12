<label for="captcha" style="color: #8D8D8D; font-family:arial; font-weight: normal;">
	<img src="include/captcha.php">
	<img src="assets/img/reload.png" style="padding-left:2em; padding-top:0.1em; width:60px;" onclick="cargar();">
</label>
<input tabindex="3" name="captcha" id="captcha" type="text" class="form-control" class="text <?php echo $captcha ?>" placeholder="Ingrese el captcha" required/>