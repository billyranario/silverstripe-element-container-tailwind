<div class="container relative w-full px-4 {{ $CSSClass }}" style="background-image: url('$BackgroundImage.URL');">
    <div class="{{ $getGridClasses }}">
        <% loop $Elements %>
            <div class="column {{ $CSSClass }}">
                $Me
            </div>
        <% end_loop %>
    </div>
</div>
