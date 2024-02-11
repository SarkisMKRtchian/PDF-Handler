document.addEventListener("DOMContentLoaded", () => {
    const pdfInput = document.getElementById("load_pdf");
    pdfInput.addEventListener("change", doc => {
        const file = doc.target.files;
        if(!file.length) {
            deleteNextBtn(); return;
        };

        setPdfView(file[0]);
    })

    const logsBtn = document.getElementById("logs");
    
    logsBtn.addEventListener("click", renderLog);

    document.addEventListener("click", event => {
        event.target.id === "close" && closeLog(); 
    })

})

// Выводит на экран PDF файл
function setPdfView(pdf){
    if(pdf.type !== "application/pdf") {
        error("Пожалуйста загрузитье файл с расширением PDF!"); return;
    }
    const view = document.getElementById('pdf_view');
    const doc  = URL.createObjectURL(pdf);
    view.setAttribute("src", doc);
    renderNextBtn()
}

// Рисует кнопку след страница
function renderNextBtn() {
    const form = document.querySelector("form");
    form.insertAdjacentHTML("beforeend", `<button type="submit">Следующая страница</button>`);
}

// Удаляет кнопку след страница
function deleteNextBtn(){
    document.querySelector("button[type=submit]") && document.querySelector("button[type=submit]").remove();
}

// Рисует предупреждение об ошибках (для оптимизации можно засунуть в timeout и через 5 сек удалить из ДОМ)
function error(text){
    const toast = `
    <div class="toaster toast_false">
        <p>${text}</p>
    </div>`; 
    document.body.insertAdjacentHTML("beforeend", toast);
}

// Делает запрос на сервер и рисует окно с логами
async function renderLog(){
    const response = await fetch("./handler.php?logs");
    const data = await response.json();
    const html = data.length > 0 ?  `
    <div class="log">
        <div>
            <svg id="close" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier"> 
                    <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#ff0000"></path> 
                </g>
            </svg>
        </div>
        ${data.map(str => {
            return `
                <p style="display: flex; align-items: center;">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                        </g>
                    </svg>
                ${str}
                </p>`
        }).join("\n")}
    </div>
    ` : `<div class="toaster toast_ok">
            <p>Ошибок нет!</p>
        </div>`;

    document.body.insertAdjacentHTML("beforeend", html);
}

// Закрывает окно с логами
function closeLog(){
    const logWindow = document.querySelector(".log");
    logWindow && logWindow.remove(); 
}