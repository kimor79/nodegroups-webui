  </div><!-- end doc2 -->
 </div><!-- end bd -->
 <div id="ft">
  <div class="space"></div>
  <hr>
  <div id="doc2">
   <div class="yui-gb footer">
    <div class="yui-u first">&nbsp;</div>
    <div class="yui-u align-center">&copy; 2012 Kimo Rosenbaum and Contributors. All Rights Reserved.</div>
    <div class="yui-u align-right"><a href="https://github.com/kimor79/nodegroups-ui">github</a></div>
   </div>
  </div>
 </div><!-- end ft -->
</div><!-- end doc4 -->

<div id="wui-status" class="hidden wui-status-dismiss wui-status-top"></div>

<div id="create-nodegroup" class="hidden">
 <div class="hd">Create Nodegroup</div>
 <div class="bd">
  <form name="create-nodegroup" method="POST" action="<?php echo $api_uri; ?>/v1/w/create_nodegroup.php?outputFormat=json">
   <table>
    <tr>
     <td><label for="nodegroup">Nodegroup:</label></td>
     <td><input type="text" name="nodegroup" size="30"></td>
    </tr>
    <tr>
     <td><label for="description">Description:</label></td>
     <td><textarea name="description" rows="3" cols="30"></textarea></td>
    </tr>
    <tr>
     <td colspan="2"><label for="expression">Expression:</label><br>
      <textarea name="expression" rows="10" cols="80"></textarea>
     </td>
    </tr>
   </table>
  </form>
 </div>
</div>

</body>
</html>
