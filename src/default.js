init();


function init() {
    initColorPalette();
}

function initColorPalette() {
    for (var elem of document.querySelectorAll(".lj-colorBox")) {
        elem.addEventListener("click", updateBgColor);
    }

    document.getElementById("bgColorInput").addEventListener("change", updateBgColorWithCustomColor, false);
}

function updateBgColor(event) {
    document.body.removeAttribute("style");

    clickedElmtClass = event.target.className;
    document.body.className = clickedElmtClass.replace("lj-colorBox", "");
}

function updateBgColorWithCustomColor(event) {
    document.body.style.backgroundColor = event.target.value;
}