<ul $AttributesHTML>
	<% loop $Options %>
		<li class="$Class<% if $isChecked %> ischecked<% end_if %>">
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
			<div class="icon-wrap">
				<span class="icon $ID.Lowercase"></span>
			</div>
			<label for="$ID">$Title</label>
		</li>
	<% end_loop %>
</ul>
