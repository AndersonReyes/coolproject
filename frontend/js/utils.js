function search_query(query, tag) {
    var list_items = document.getElementById(tag).getElementsByTagName("li");
    for (var item of list_items) {
        // If query is not in list then hide it other wise display it
        if (item.textContent.toLowerCase().indexOf(query) === -1) {
            item.style.display = "none";
        } else {
            item.style.display = "";
        }
    }

}