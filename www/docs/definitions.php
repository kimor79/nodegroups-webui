<?php

include('top.inc');

?>

<p>

<ul>
 <li>
  <b>Node</b> - A singular abstract basic unit, most often a hostname or an IP address.
  <ul>
   <li>A node may only be a valid IP address (v4 or v6) or contain alphanumeric characters, dots, dashes or underscores.</li>
  </ul>
 </li>
 <li><b>Nodegroup</b> - A collection of entities (nodes, nodegroups, functions).
  <ul>
   <li>A nodegroup name may only contain alphanumeric characters, dots, dashes or underscores.</li>
   <li>To reference a nodegroup in an expression or function, prefix the name with an '@': @foo.</li>
  </ul>
 </li>
 <li><b>Function</b> - A subroutine which evaluates all elements within and returns a list of nodes.
  <ul>
   <li><i>&amp;diff()</i> - The set of nodes in the first element that are not present in any other element of the function.</li>
   <li><i>&amp;union()</i> - The set of the nodes from all elements of the function.</li>
   <li><i>&amp;intersect()</i> - The set of nodes common to all elements of the function.</li>
   <li><i>&amp;regexp()</i> - The set of nodes which match the given regexp (first element).</li>
   <li>Function elements may be individual nodes, nodegroups or functions.</li>
   <li>Elements are separated by a single comma: &amp;union(@foo, @bar).</li>
  </ul>
 </li>
 <li><b>Expression</b> - A combination of entities used to define a nodegroup.
  <ul>
   <li>An entity may be excluded by prefixing the entity with an '!': !foo.</li>
   <li>An entity may be commented out by prefixing the entity with a '#': #foo.</li>
   <li>Exclusions and comments within functions are local to that function only.</li>
  </ul>
 </li>
</ul>

</p>

</body>
</html>
