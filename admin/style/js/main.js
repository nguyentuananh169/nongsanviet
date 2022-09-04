var bars = document.querySelector('.bars i');
var containerLeft = document.querySelector('.container-left');
var widthContainerLeft = containerLeft.clientWidth;
bars.addEventListener('click',function(){
	if (containerLeft.hasAttribute('name')) {
		containerLeft.style.marginLeft = '0';
		containerLeft.removeAttribute('name');
	}else{
		containerLeft.style.marginLeft = '-' + widthContainerLeft + 'px';
	    containerLeft.setAttribute('name','event');
	}
});
/*------------------*/
var dropdownMenu = document.querySelectorAll('.nav-menu-item ul li.dropdown-menu');
for (var i = 0; i < dropdownMenu.length; i++) {
	dropdownMenu[i].addEventListener('click',function(){
		var menuCon = document.querySelectorAll('.nav-menu-item ul li.dropdown-menu ul');
		for (var i = 0; i < menuCon.length; i++) {
			menuCon[i].style.height = '0';
		}
		
		if (this.hasAttribute('name')) {
			this.removeAttribute('name');
			this.classList.remove('show');
		}else{
			for (var i = 0; i < dropdownMenu.length; i++) {
				dropdownMenu[i].classList.remove('show');
				dropdownMenu[i].removeAttribute('name','event');
			}
			this.classList.add('show');
			this.setAttribute('name','event');
			var ShowMenuLi_All = document.querySelectorAll('.nav-menu-item ul li.dropdown-menu.show ul.menu-con li');
			var ShowMenuLi = document.querySelector('.nav-menu-item ul li.dropdown-menu.show ul.menu-con li');
			var ShowMenuCon = document.querySelector('.nav-menu-item ul li.dropdown-menu.show ul.menu-con');
			ShowMenuCon.style.height = ShowMenuLi_All.length * ShowMenuLi.clientHeight +'px';
		}
    });
}
