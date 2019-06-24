init();


function init() {
    initColorPalette();
}

function initColorPalette() {
    for (var elem of document.querySelectorAll(".lj-colorBox")) {
        elem.addEventListener("click", updateBgColor);
    }
}



function updateBgColor(event) {
    clickedElmtClass = event.target.className;
    document.body.className = clickedElmtClass.replace("lj-colorBox", "");
}