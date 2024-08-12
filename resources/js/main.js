const main = document.querySelector("main")
const header = document.querySelector("header")
const nav = document.querySelector("nav")

const navObserverCallback = (watchEntry, navObserver) => {
    if (watchEntry[0].isIntersecting) {
        console.log(watchEntry[0].isIntersecting);
        nav.classList.add('nav-active');
    }else{
        nav.classList.remove('nav-active');
    }
}
const navObserverOptions = {
    
  };
  
let navObserver = new IntersectionObserver(navObserverCallback, navObserverOptions);
navObserver.observe(main)