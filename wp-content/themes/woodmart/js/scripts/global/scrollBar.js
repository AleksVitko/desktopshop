const htmlElement = document.getElementsByTagName('html')[0];
const windowWidth = window.innerWidth;

if (windowWidth > 1024 && windowWidth > htmlElement.offsetWidth) {
	const scrollbarWidth = window.innerWidth - htmlElement.offsetWidth;
	const styleElement = document.createElement('style');

	styleElement.textContent = `:root {--wd-scroll-w: ${scrollbarWidth}px;}`;
	document.head.appendChild(styleElement);
}