# good-job

## 1.1. Регистрация + Авторизация

1. Реализован стандартный модуль auth с двумя ролями:
2. Менеджер и Клиент.
3. Клиенты регистрируются самостоятельно, аккаунт Менеджера создан заранее.
4. После авторизации Клиенту доступна форма обратной связи в меню, а Менеджеру список заявок на обратную связь.
5. Все страницы и функционал доступны только авторизованным пользователям в соответствии с их правами.

## 1.2. Страница с формой обратной связи

Реализованы поля формы:
* Для ввода темы сообщения.
* Для ввода текста сообщения.
* Для загрузки файла.
* Кнопка для отправки формы.
* Размер загружаемого файла не превышает 3 MB.
* Установлен запрет на загрузку файлов с расширениями .bat, .jar, .exe.
* Обязательное заполнение всех полей, валидация на клиенте и на сервере.
* Клиент может оставлять заявку не чаще раза в сутки.

## 1.3. Страница со списком заявок на обратную связь

Реализованы поля таблицы:
* ID Клиента.
* Время создания Клиента.
* Время отправки сообщения.
* Имя Клиента.
* E-mail Клиента.
* Тема сообщения.
* Текст сообщения.
* Ссылка на прикрепленный файл.
* В таблице реализована сортировка по полю “Время отправки сообщения”.
* Реализована пагинация, с возможностью выбора количества отображаемых строк на странице (10, 50, 100).
* Пагинация и сортировка записей таблицы выполняется без перезагрузки страницы.

