var menuHeader = document.querySelector('.my-header');
document.addEventListener('scroll',headerScroll);
function headerScroll(){
	if (document.documentElement.scrollTop > 170) {
		menuHeader.classList.add('header-fixed');
	}else{
		menuHeader.classList.remove('header-fixed');
	}
}
headerScroll();
// 
var barsTablet = document.querySelector('.bars-tablet')
var menuTablet = document.querySelector('.nav-menu-tablet')
var overlayMenuTablet = document.querySelector('.overlay-nav-menu')
var closeMenuTable = document.querySelector('.close-menu')

barsTablet.addEventListener('click', function(){
	menuTablet.classList.add('show')
	overlayMenuTablet.classList.add('show')
})

closeMenuTable.addEventListener('click', function(){
	menuTablet.classList.remove('show')
	overlayMenuTablet.classList.remove('show')
})

overlayMenuTablet.addEventListener('click', function(){
	menuTablet.classList.remove('show')
	overlayMenuTablet.classList.remove('show')
})
// 
var btnBackToTop = document.querySelector('#back-to-top');
document.addEventListener('scroll',BackToTop);
function BackToTop(){
	if (document.documentElement.scrollTop > 170) {
		btnBackToTop.style.bottom = '50px';
	}else{
		btnBackToTop.style.bottom = '-50px';
	}
}
BackToTop();
// 
var btnBackToTop = document.querySelector('#back-to-top');
btnBackToTop.addEventListener('click',toTop);
function toTop(){
	var TimebackToTop = setInterval(Time,1);
	function Time(){
		document.documentElement.scrollTop -= 50;
		if (document.documentElement.scrollTop ==0) {
			clearInterval(TimebackToTop);
		}
	}
}
// 