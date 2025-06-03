document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    
    // Устанавливаем начальное значение
    phoneInput.value = '+7(';
    
    // Обработчик ввода
    phoneInput.addEventListener('input', function(e) {
        const position = e.target.selectionStart;
        let value = e.target.value.replace(/\D/g, '');
        
        // Всегда начинаем с 7
        if (!value.startsWith('7')) {
            value = '7' + value.replace(/^7/, '');
        }
        
        // Форматирование
        let formattedValue = '+7(';
        
        if (value.length > 1) {
            formattedValue += value.substring(1, 4);
        }
        if (value.length >= 4) {
            formattedValue += ')-';
            if (value.length > 4) {
                formattedValue += value.substring(4, 7);
            }
        }
        if (value.length >= 7) {
            formattedValue += '-';
            if (value.length > 7) {
                formattedValue += value.substring(7, 9);
            }
        }
        if (value.length >= 9) {
            formattedValue += '-';
            if (value.length > 9) {
                formattedValue += value.substring(9, 11);
            }
        }
        
        e.target.value = formattedValue;
        
        // Корректируем позицию курсора
        if (position < 3) {
            e.target.setSelectionRange(3, 3);
        } else {
            e.target.setSelectionRange(position, position);
        }
    });
    
    // Обработчик удаления
    phoneInput.addEventListener('keydown', function(e) {
        // Разрешаем выделить и удалить всё (Ctrl+A + Delete/Backspace)
        if ((e.key === 'Delete' || e.key === 'Backspace') && 
            (e.target.selectionEnd - e.target.selectionStart === e.target.value.length)) {
            e.target.value = '+7(';
            e.preventDefault();
            return;
        }
        
        // Запрещаем удаление первых 3 символов по отдельности
        if (e.target.selectionStart <= 3 && 
            e.target.selectionStart === e.target.selectionEnd && 
            (e.key === 'Backspace' || e.key === 'Delete')) {
            e.preventDefault();
        }
    });
    
    // Обработчик потери фокуса
    phoneInput.addEventListener('blur', function(e) {
        if (e.target.value === '+7(') {
            e.target.value = '';
        }
    });
    
    // Обработчик получения фокуса
    phoneInput.addEventListener('focus', function(e) {
        if (e.target.value === '') {
            e.target.value = '+7(';
        } else if (e.target.value.length < 3) {
            e.target.value = '+7(';
        }
    });
});

// Функция validateForm остается без изменений
function validateForm() {
    const login = document.getElementById('login').value;
    const password = document.getElementById('password').value;
    const fullname = document.getElementById('fullname').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const error = document.getElementById('error');

    if (!/^[А-Яа-яЁё]{6,}$/.test(login)) {
        error.textContent = 'Логин должен содержать минимум 6 символов кириллицы';
        return false;
    }

    if (password.length < 6) {
        error.textContent = 'Пароль должен содержать минимум 6 символов';
        return false;
    }

    if (!/^[А-Яа-яЁё\s]+$/.test(fullname)) {
        error.textContent = 'ФИО должно содержать только кириллицу и пробелы';
        return false;
    }

    if (!/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/.test(phone)) {
        error.textContent = 'Введите корректный номер телефона в формате +7(999)-999-99-99';
        return false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        error.textContent = 'Введите корректный email адрес';
        return false;
    }

    return true;
}