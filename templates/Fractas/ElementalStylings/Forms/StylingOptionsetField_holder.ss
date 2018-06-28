<div id="$HolderID" class="form-group field<% if $extraClass %> $extraClass<% end_if %>">
	<% if $Title %>
		<label for="$ID" id="title-$ID" class="form__field-label">$Title</label>
	<% end_if %>
	<div class="form__field-holder middleColumn">
		$Field
	</div>
	<% if $RightTitle %><label class="right">$RightTitle</label><% end_if %>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
</div>
