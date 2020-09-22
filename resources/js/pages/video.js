document.addEventListener('DOMContentLoaded', () => {
    var v = document.getElementsByClassName("youtube-player");
    var overlayText = document.getElementById("overlay-text");
    if (v.length > 0) {
        var div,
            n;
        for (n = 0; n < v.length; n++) {
            div = document.createElement("div");
            div.setAttribute("data-id", v[n].dataset.id);
            div.innerHTML = noThumb(v[n].dataset.id, overlayText);
            div.onclick = noIframe;
            v[n].appendChild(div);
        }
    }
});

function noThumb(id, overlayTextContent) {
    var thumb = '<img src="https://i.ytimg.com/vi/ID/maxresdefault.jpg">',
        overlayText = '\'<div class="text-video">' + overlayTextContent.innerHTML + '</div>',
        play = '<div class="play"></div>';
    return thumb.replace("ID", id) + play + overlayText;
}

function noIframe() {
    var iframe = document.createElement("iframe");
    var embed =
        "https://www.youtube-nocookie.com/embed/ID?autoplay=1&modestbranding=1&iv_load_policy=3&rel=0&showinfo=0";
    iframe.setAttribute("src", embed.replace("ID", this.dataset.id));
    iframe.setAttribute("frameborder", "0");
    iframe.setAttribute("allowfullscreen", "1");
    iframe.setAttribute("allow", "autoplay; encrypted-media");
    this.parentNode.replaceChild(iframe, this);
}
