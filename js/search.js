$(document).ready(function () {
    $("#searchID").keyup(function (e) {
        let code = e.keyCode || e.which;
        if (code === 13) {
            searchProduct();
        }
    });
});

function searchProduct() {
    let input = document.getElementById("searchID");
    if (!input) {
        return;
    }

    let query = (input.value || "").trim();

    if (query === "") {
        if (typeof notifyWarning === "function") {
            notifyWarning("Type a product name to search");
        }
        input.focus();
        return;
    }

    window.location.href = "/pages/catalog/results.php?text=" + encodeURIComponent(query);
}
