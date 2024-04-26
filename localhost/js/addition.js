// Добавление модуля
document.addEventListener('DOMContentLoaded', function () {
    const modulesList = document.getElementById('modulesList');
    const addModuleBtn = document.querySelector('.add_module');

    addModuleBtn.addEventListener('click', function () {
        const newModule = document.createElement('li');
        newModule.innerHTML = `
            <div>
                <input class="button-box" type="text" name="module_${modulesList.childElementCount + 1}" placeholder="Название модуля">
                <button type="button" class="remove_module button-box" data-module="${modulesList.childElementCount + 1}">-</button>
            </div>
            <ol>
                <li>
                    <div style="margin: 1vh;">
                        <input class="button-box" type="text" name="lesson_${modulesList.childElementCount + 1}_1" placeholder="Название урока">
                        <button type="button" class="add_lesson button-box" data-module="${modulesList.childElementCount + 1}" data-lesson="1">+</button>
                        <button type="button" class="remove_lesson button-box" data-module="1" data-lesson="1">-</button>
                    </div>
                </li>
            </ol>
        `;
        modulesList.appendChild(newModule);
    });

    // Удаление модуля
    modulesList.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove_module')) {
            e.target.parentElement.parentElement.remove();
        }
    });

    // Добавление урока
    modulesList.addEventListener('click', function (e) {
        if (e.target.classList.contains('add_lesson')) {
            const moduleNumber = e.target.getAttribute('data-module');
            const lessonsList = e.target.parentElement.parentElement;
            const newLesson = document.createElement('li');
            newLesson.innerHTML = `
                <div style="margin: 1vh;">
                    <input class="button-box" type="text" name="lesson_${moduleNumber}_${lessonsList.childElementCount + 1}" placeholder="Название урока">
                    <button type="button" class="add_lesson button-box" data-module="${moduleNumber}" data-lesson="${lessonsList.childElementCount + 1}">+</button>
                    <button type="button" class="remove_lesson button-box" data-module="${moduleNumber}" data-lesson="${lessonsList.childElementCount + 1}">-</button>
                </div>
            `;
            lessonsList.appendChild(newLesson);
        }
    });

    // Удаление урока
    modulesList.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove_lesson')) {
            e.target.parentElement.parentElement.remove();
        }
    });
});

