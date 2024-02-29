
const voirPlus = document.querySelector("#voirPlus");
const comms = document.querySelector("#comm");

let offset = 0;
voirPlus.addEventListener("click", function(){

    offset += 2;

    fetch("../import.php?id=1&offsetpost=" + offset, {
        method: "POST",
        /*body: url,*/
        headers:{
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
    .then(res => res.json())
    .then(data => {

        data.forEach(comments => {

            const newDiv = document.createElement("div");
            newDiv.classList.add("bg-secondary");
            newDiv.classList.add("mt-3");
            newDiv.classList.add("mb-3");
            newDiv.innerHTML = `<ul class="list-group">
            <li class="list-group-item"><strong>Auteur :</strong>  ${comments.email} </li>
            <li class="list-group-item"><strong>Sujet :</strong> ${comments.name} </li>
            <li class="list-group-item"><strong>Contenu :</strong> ${comments.body} </li>
            <li class="list-group-item"><strong>Envoyé le : </strong> ${comments.createdAt} </li>
            </ul>`;
            voirPlus.insertAdjacentElement("beforebegin", newDiv);
            
        });
    })
    .catch(err => console.error(err))

})