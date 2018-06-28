<div class="styling-block-preview">
  <% if $Image %>
    <div class="styling-block-preview__image">
      <% with $Image %>
      <img src="$Fill(36,36).URL" alt="$Title">
      <% end_with %>
    </div>
  <% end_if %>
  <% if $Description %>
    <div class="styling-block-preview__description">$Description.RAW</div>
  <% end_if %>

  <% if $Styling %>
    <ul class="styling-block-preview__list">
      <% loop $Styling %>
          <% if $Value %>
          <li class="styling-block-preview__list-item">
              <strong>{$Label}</strong>$Value
          </li>
          <% end_if %>
      <% end_loop %>
    </ul>
<% end_if %>
</div>
