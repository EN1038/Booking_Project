function hideElements() {
    var elementsToHide = document.getElementsByClassName("divToHide");
  
    for (var i = 0; i < elementsToHide.length; i++) {
      elementsToHide[i].classList.add("delay-close");
    }
  }
  
  function showElements() {
    var elementsToShow = document.getElementsByClassName("divToHide");
  
    for (var i = 0; i < elementsToShow.length; i++) {
      elementsToShow[i].classList.add("delay-show");
      elementsToShow[i].classList.remove("delay-close");
    }
  }
  
  
  function closeNav() {
    document.getElementById("mySidenav").style.width = "70px";
    document.getElementById("main").style.marginLeft = "80px";
    document.getElementById("profiles").style.width = "40px";
    hideElements(); // เรียกใช้ hideDivs เพื่อซ่อน div ทุกตัว
    
  }
  
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "280px";
    document.getElementById("profiles").style.width = "55px";
    showElements(); // เรียกใช้ showDivs เพื่อแสดง div ทุกตัว
    
  }
  
  function toggleNav() {
    var sidenav = document.getElementById("mySidenav");
    var openNavButton = document.getElementById("openNavButton");
    
    if (sidenav.classList.contains("opened")) {
      sidenav.classList.remove("opened");
      openNavButton.classList.remove("nav-opened");
    } else {
      sidenav.classList.add("opened");
      openNavButton.classList.add("nav-opened");
    }
  }
  
  // ตรวจสอบขนาดหน้าจอเมื่อโหลดหน้าเว็บ
  window.onload = function() {
    checkWindowSize();
  };
  
  // ตรวจสอบขนาดหน้าจอเมื่อมีการเปลี่ยนแปลงของหน้าต่างเบราว์เซอร์
  window.addEventListener('resize', function(event) {
    checkWindowSize();
  });
  
  
  function checkWindowSize() {
    const windowWidth = window.innerWidth;
    let sideNav = document.getElementById("mySidenav");
    let imageProfile = document.getElementById("profiles");
    var openNavButton = document.getElementById("openNavButton");
    // เช็คขนาดหน้าจอ
    if (windowWidth <= 1220) {
      document.getElementById("mySidenav").style.width = "0px";
      document.getElementById("main").style.marginLeft = "30px";
    } else {
      if(sideNav.style.width === '70px'){
        sideNav.style.width = '70px';
        imageProfile.style.width = '40px';
        openNavButton.classList.add("nav-opened");
      }else{
        document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "280px";
      openNavButton.classList.remove("nav-opened");
      showElements();
  
      }
      
    }
  }
  
  
  
