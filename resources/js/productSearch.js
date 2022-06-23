function sendRequest(url, method, data) {
    const xhr = new XMLHttpRequest();

    xhr.open(method, url + data);

    xhr.send();

    return xhr;
}


let searchInput = document.querySelector('#main__search__input');
let searchBtn = document.querySelector('#main__search__btn');
let searchResultBlock = document.querySelector('#main__search__result');

searchBtn.addEventListener('click', function () {
    let xhr = (sendRequest(`${window.location.origin}/search/product`, 'get', `?productName=${searchInput.value}`));
    let response = [];

    xhr.onreadystatechange = function () {
        if (xhr.status === 200) {
            let data = JSON.parse(xhr.response);
            renderSearchResult(data);
        }
    }

    function renderSearchResult(response) {
        searchResultBlock.style.display = 'block';
        searchResultBlock.innerHTML = "";
        if (response[0].length === 0)
        {
            searchResultBlock.innerHTML = "Нет результатов";
        }
        response[0].forEach(function (e) {
            searchResultBlock.innerHTML += `<a href='${window.location.origin}/product/show/${e.id}'>${escapeHtml(e.name)}</a><br>`;
        });
    }


});

window.addEventListener('click', function (){
    searchResultBlock.style.display = 'none';
});

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
