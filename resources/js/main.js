const main = document.querySelector("main")
const header = document.querySelector("header")
const nav = document.querySelector("#Navbar1")

let options = {
  root: nav,
  rootMargin: "0px",
  threshold: 1.0,
};

let callback = (entries, observer) => {
    console.log(entries)
};

let observer = new IntersectionObserver(callback, options);

let target = document.querySelector("#Header");
observer.observe(target);