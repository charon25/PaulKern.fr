// Fix footer at bottom of page
var footer = document.getElementById("footer");
if (screen.width >= 764) {
	footer.style.position = "fixed";
	footer.style.bottom = 0;
	footer.style.left = 0;
	footer.style.right = 0;
} else {
	footer.remove();
}
