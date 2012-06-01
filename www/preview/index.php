<?php

include_once 'nodegroups/webui/includes/init.php';
include_once 'nodegroups/webui/includes/top.php';

?>

<div class="yui-ge">
 <div class="yui-u first wui-boxa">
  <form id="preview-expression" method="POST" action="">
   <table>
    <tr>
     <td><label for="expression">Expression:</label></td>
    </tr>
    <tr>
     <td>
      <textarea name="expression"><?php echo htmlentities($wui->getGET('expression')); ?></textarea>
     </td>
    </tr>
   </table>
   <div class="align-right">
    <input type="button" class="preview-expression" value="Preview">
    <input type="reset" value="Reset">
   </div>
  </form>
 </div>
</div>

<div class="space"></div>

<div id="preview" class="hidden">
 <h3>Preview</h3>
 <textarea id="nodes-list" readonly="readonly"></textarea>
</div>

<?php

include_once 'nodegroups/webui/includes/bottom.php';

?>
