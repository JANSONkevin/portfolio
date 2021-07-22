/* document.getElementById('searchField').addEventListener('input', function (event) {
    var q = document.getElementById('searchField').value;
    const ul = document.getElementById('autocomplete');
    ul.innerHTML = "";


    fetch('/autocomplete?q=' + q)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {

                const li = document.createElement('li');
                const link = document.createElement('a');

                link.href = '/project/'+data[i].slug;
                link.innerHTML = data[i].title;

                li.appendChild(link);
                ul.appendChild(li);
            }
        })
        console.log(response)
        .catch((error) => alert(error));
}); */

