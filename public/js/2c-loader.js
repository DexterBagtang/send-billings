function loader (url, loaded) {
    // (A) GET HTML ELEMENTS
    var main = document.getElementById("main"),
        loading = document.getElementById("loading");

    // (B) LOADING SPINNER
    loading.classList.add("load");

    // (C) AJAX LOAD PAGE
    fetch(url)
        .then(res => res.text())
        .then(txt => {
            main.innerHTML = txt;
            if (typeof loaded == "function") { loaded(); }
        })
        .finally(() => {
            loading.classList.remove("load");
        });
}
