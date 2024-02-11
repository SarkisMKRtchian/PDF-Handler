document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("click", event => {
        switch(event.target.id){
            case "add_user": renderForm();   break;
            case "close":    closeForm();    break;
            case "submit":   addUser(event); break;
        }

    })

    document.addEventListener("change", event => {
        switch(event.target.id){
            case "send_type":  selectHandler(event.target); break;
        }
    })
})

// Рисует форму добавления юзера
function renderForm(){
    const html = `
    <div class="add_user">
        <form action method="post">
            <div>
                <svg id="close" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> 
                        <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#ff0000"></path> 
                    </g>
                </svg>
            </div>
            <label for="send_type">Выберите способ отправик документа:</label>
            <select name="send_type" id="send_type">
                <option value="telegram">Телеграм</option>
                <option value="email">Эл. почта</option>
            </select>

            <label for="user_id">Введитье телеграм ник:</label>
            <input required type="number" name="user_id" id="user_id">

            <label for="fullName">Введитье ФИО:</label>
            <input required type="text" name="fullName" id="fullName" placeholder="Иванов Иван Иванович">

            <input type="text" hidden name="addUser">

            <p id="err" style="display: none">Заполните все поля!</p>
            <button id="submit" type="submit">Добавить</button>

        </form>
    </div>
    `;
    const body = document.querySelector('body');

    body.insertAdjacentHTML("beforeend", html);
}

// Закрывает форму добавления юзера
function closeForm(){
    const form = document.querySelector('.add_user');
    form && form.remove();
}

// Переключаеть между выборкой телеграм - эл. почта
function selectHandler(select){
    const userId = document.getElementById("user_id");
    userId.setAttribute("type", select.value === 'telegram' ? "number" : "email");

    const userIdLable = document.querySelector("label[for='user_id']");
    userIdLable.innerText = select.value === 'telegram' ? "Введитье ваш телеграм ник:" : "Введитье ваш эл. адрес:";
}

// Добавление нового юзера
async function addUser(event){
    event.preventDefault();
    const form = document.querySelector(".add_user form");
    if(!form) return;

    const inputs = form.querySelectorAll("input");
    // Проверка на пустоту input-ов
    for(const input of inputs){
        if(input.value === '' && !input.hasAttribute("hidden")) {
            form.querySelector("#err").setAttribute("style", "display: block");
            input.setAttribute("style", "box-shadow: 0px 0px 5px red");
            return;
        }else{
            form.querySelector("#err").setAttribute("style", "display: none");
            input.setAttribute("style", "box-shadow: 0px 0px 5px gray");
        }
    }

    const formData = new FormData(form);
    const response = await fetch(location.href, {
        method: "post",
        body: formData
    })

    if(!response.ok){
        const toast = `
        <div class="toaster toast_${data ? "ok" : "false"}">
            <p>Не удалось добавить пользователя</p>
        </div>`; 

        document.body.insertAdjacentHTML("beforeend", toast); return;
    }

    const data = await response.json();
    // После обработки закрывает форму и рисует диалоговое окно с инормацией о выполнении 
    closeForm();
    const toast = `
    <div class="toaster toast_${data ? "ok" : "false"}">
        <p>${data ? "Пользователь успешно добавлен" : "Не удалось добавить пользователя"}</p>
    </div>`; 

    document.body.insertAdjacentHTML("beforeend", toast);

}