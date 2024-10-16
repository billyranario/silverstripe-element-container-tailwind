<% if $BackgroundImage %>
    <div class="column relative {{ $CSSClass }}" style="background-image: url('$BackgroundImage.URL');">
        <div class="overlay"></div>
        <% if $Elements %>
            $Elements
        <% end_if %>
    </div>
<% else %>
    <div class="column {{ $CSSClass }}">
        <% if $Elements %>
            $Elements
        <% end_if %>
    </div>
<% end_if %>
