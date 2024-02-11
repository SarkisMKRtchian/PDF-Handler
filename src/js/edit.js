document.addEventListener("DOMContentLoaded", () => {
    // При клике на верхний чекбокс меняем все остальные(включить, отключить)
    const checkAll = document.getElementById("checkAll");
    checkAll.addEventListener("click", event => {
        const checkboxses = document.querySelectorAll("#checkbox");
        
        checkboxses.forEach(checkbox => {
            checkbox.checked = checkAll.checked;
        })
        
    })
})