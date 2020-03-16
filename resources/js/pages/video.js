document.addEventListener('DOMContentLoaded', () => {
    var v = document.getElementsByClassName("youtube-player");
    if (v.length>0) {
        var div,
            n;
        for (n = 0; n < v.length; n++) {
            div = document.createElement("div");
            div.setAttribute("data-id", v[n].dataset.id);
            div.innerHTML = noThumb(v[n].dataset.id);
            div.onclick = noIframe;
            v[n].appendChild(div);
        }
    }
});

function noThumb(id) {
    var thumb = '<img src="https://i.ytimg.com/vi/ID/maxresdefault.jpg">',
        overlayTitle = '<div class="title-video"><span>HISTOIRES D’UNE RÉUSSITE</span><h2 class="title is-2">La Tournerie : histoire d’une ferme pas comme les autres.</h2></div>',
        overlayText = '<div class="text-video"><p>Didascalie vidéo, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p></div>',
        play = '<div class="play"></div>';
    return thumb.replace("ID", id) + play + overlayTitle + overlayText;
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
