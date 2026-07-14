<ul $AttributesHTML>
	<% loop $Options %>
		<li class="$Class<% if $isChecked %> ischecked<% end_if %>">
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
			<label for="$ID" class="styling-option">
				<span
					class="styling-option__icon"
					data-styling-name="$Name.Lowercase"
					data-styling-value="$Value.Lowercase"
					aria-hidden="true"
				></span>
				<span class="styling-option__label">$Title</span>
			</label>
		</li>
	<% end_loop %>
</ul>
