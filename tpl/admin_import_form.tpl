<div class='content'>
{$message}
{$import_files}
<form action='?' method='post'>
<select name='path'>
<option value=''>./</option>
{$path_opt}
</select><br/>
{$url} | {$name}<br/>
رابط الملف المباشر:
<br>
<input type='text' name='f[]' value='http://'>
<br>اسم الملف<br>
<input type='text' name='n[]'><br/>
<input type='submit' value='{$import_files}'>
</form>
</div>