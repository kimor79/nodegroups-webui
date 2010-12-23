<?php

include('top.inc');

?>

<p>

<h3>A nodegroup containing several autong</h3>
<textarea class="textareaExample" readonly rows="3" cols="80">
nasmar1.sjc1.mydomain.com
nasmar2.sjc1.mydomain.com
nasmar3.sjc1.mydomain.com
</textarea>

<h3>A nodegroup containing several nodegroups and several autong</h3>
<textarea class="textareaExample" readonly rows="5" cols="80">
nasmar1.sjc1.mydomain.com
@autong.site_id.1
@autong.site_id.14
nasmar5.sjc1.mydomain.com
soileh1.cdg1.mydomain.com
</textarea>

<h3>A nodegroup containing functions</h3>
<textarea class="textareaExample" readonly rows="2" cols="80">
&intersect(@autong.site_id.4, @autong.glob.util)
&regexp(/^nasmar1\./, @autong.glob.nasmar)
</textarea>

<h3>Exclusion</h3>
<textarea class="textareaExample" readonly rows="3" cols="80">
@autong.site_id.1
!@autong.glob.soileh
&union(@autong.site_name.iad1, @autong.site_name.mia1, !soileh1.iad1.mydomain.com)
</textarea>

</p>

</body>
</html>
